<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Semester;
use App\Models\ClassSubject;
use App\Models\School;
use App\Models\FinalGrade;
use App\Models\Attendance;
use App\Models\Note;
use App\Models\Promotion;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportPrintController extends Controller
{
    public function mid(Student $student, ?Semester $semester = null)
    {
        // 1) Semester aktif (jika tidak diberikan)
        if (!$semester) {
            $semester = Semester::where('active', 1)->firstOrFail();
        }

        // 2) Kelas siswa pada saat ini (sederhana: dari kolom class_id milik siswa)
        $class = $student->class()
            ->with(['wali']) // relasi ke users (wali_kelas_id)
            ->first();

        // 3) Data sekolah
        $school = School::first();

        // 4) Tanggal rapor tengah semester (opsional)
        $reportDate = DB::table('report_dates')
            ->where('semester_id', $semester->id)
            ->where('class_id', $class->id ?? 0)
            ->value('mid_report_date'); // kolomnya ada sesuai dump :contentReference[oaicite:7]{index=7}

        // 5) Ambil seluruh mapel di kelas & semester ini (urut menggunakan order_no)
        $classSubjects = ClassSubject::query()
            ->where('semester_id', $semester->id)
            ->where('class_id', $class->id)
            ->with('subject')
            ->orderBy('order_no') // kolomnya ada di class_subjects :contentReference[oaicite:8]{index=8}
            ->get(['id','subject_id','order_no']);

        $csIds = $classSubjects->pluck('id');

        if ($csIds->isEmpty()) {
            return view('rapor.mid', [
                'student'     => $student,
                'semester'    => $semester,
                'school'      => $school,
                'class'       => $class,
                'reportDate'  => $reportDate,
                'rows'        => collect(),
                'avgAll'      => null,
            ]);
        }

        // 6) Hitung nilai per mapel (formatif + sumatif) berbasis bobot
        //    - type ada di kolom `type` pada assessments :contentReference[oaicite:9]{index=9}
        //    - nilai siswa di assessment_scores.score :contentReference[oaicite:10]{index=10}
        $agg = DB::table('assessments as a')
            ->join('assessment_scores as s', 's.assessment_id', '=', 'a.id')
            ->selectRaw("
                a.class_subject_id,
                SUM( CASE WHEN a.type='formatif' THEN (s.score/a.max_score)*100 END )       AS fmt_points,
                SUM( CASE WHEN a.type='formatif' THEN 1 END )                                AS fmt_n,
                AVG( CASE WHEN a.type='sumatif'  THEN (s.score) END )                         AS pts_raw,
                SUM( (s.score/a.max_score)*100 * a.weight )                                  AS total_w,
                SUM( a.weight )                                                              AS sum_w
            ")
            ->whereIn('a.class_subject_id', $csIds)
            ->where('s.student_id', $student->id)
            ->whereIn('a.type', ['formatif','sumatif']) // gunakan `type`, bukan category/kategori/jenis
            ->groupBy('a.class_subject_id')
            ->get()
            ->keyBy('class_subject_id');

        // 7) Rakit baris untuk view
        $rows = $classSubjects->map(function ($cs) use ($agg) {
            $x = $agg->get($cs->id);
            $fmt = $x && $x->fmt_n ? round($x->fmt_points / $x->fmt_n, 0) : null; // rata formatif (0-100)
            $pts = $x && $x->pts_raw !== null ? round($x->pts_raw, 0) : null;     // PTS mentah (asumsi skala 0-100)
            $mid = $x && $x->sum_w > 0 ? round($x->total_w / $x->sum_w, 0) : null; // rata berbobot

            return (object)[
                'subject' => $cs->subject->nama_mapel ?? '—',
                'fmt'     => $fmt,
                'pts'     => $pts,
                'mid'     => $mid,
            ];
        });

        $avgAll = $rows->filter(fn($r) => $r->mid !== null)->avg('mid');
        if ($avgAll !== null) $avgAll = round($avgAll, 0);

        return view('rapor.mid', [
            'student'     => $student,
            'semester'    => $semester,
            'school'      => $school,
            'class'       => $class,
            'reportDate'  => $reportDate,
            'rows'        => $rows,
            'avgAll'      => $avgAll,
        ]);
    }

    public function show(Student $student, Semester $semester)
    {
        // 1) Kelas siswa
        $class = $student->class()->with(['wali'])->first();

        // 2) Data sekolah
        $school = School::first();

        // 3) Tanggal rapor semester (final_report_date)
        $reportDate = DB::table('report_dates')
            ->where('semester_id', $semester->id)
            ->where('class_id', $class->id ?? 0)
            ->value('final_report_date');

        // 4) Ambil semua mapel di kelas & semester ini (urut by order_no)
        $classSubjects = ClassSubject::query()
            ->where('semester_id', $semester->id)
            ->where('class_id', $class->id)
            ->with('subject')
            ->orderBy('order_no')
            ->get();

        // 5) Ambil nilai akhir (final_grades) untuk siswa ini
        $finalGrades = FinalGrade::query()
            ->where('student_id', $student->id)
            ->whereIn('class_subject_id', $classSubjects->pluck('id'))
            ->get()
            ->keyBy('class_subject_id');

        // 6) Rakit data mata pelajaran dengan nilai akhir dan capaian kompetensi
        $subjects = $classSubjects->map(function ($cs) use ($finalGrades) {
            $fg = $finalGrades->get($cs->id);
            $namaMapel = $cs->subject->name ?? $cs->subject->nama_mapel ?? '-';

            return [
                'nama_mapel' => $namaMapel,
                'nilai_akhir' => $fg ? round($fg->final_score, 0) : null,
                'capaian' => $this->generateCapaianKompetensi($fg ? $fg->final_score : null, $namaMapel),
            ];
        });

        // 7) Ekstrakurikuler
        $ekstra = DB::table('extracurricular_assessments as ea')
            ->join('extracurriculars as e', 'e.id', '=', 'ea.extracurricular_id')
            ->where('ea.student_id', $student->id)
            ->where('ea.semester_id', $semester->id)
            ->select('e.name as nama', 'ea.final_grade as predikat', 'ea.final_description as keterangan')
            ->get();

        // 8) Absensi
        $attendance = Attendance::where('student_id', $student->id)
            ->where('semester_id', $semester->id)
            ->first();

        // 9) Catatan wali kelas
        $note = Note::where('student_id', $student->id)
            ->where('semester_id', $semester->id)
            ->first();

        // 10) Keputusan kenaikan kelas
        $promotion = Promotion::where('student_id', $student->id)
            ->where('semester_id', $semester->id)
            ->first();

        // 11) Fase (dari kelas)
        $fase = $class->fase ?? 'F';

        // 12) Wali kelas dan kepala sekolah dengan gelar lengkap
        $wali = $class->wali ?? null;
        $waliKelas = (object)[
            'nama' => $wali ? trim(($wali->gelar_depan ? $wali->gelar_depan.' ' : '').$wali->nama.(!empty($wali->gelar_belakang) ? ', '.$wali->gelar_belakang : '')) : null,
            'nip' => $wali->nip ?? null,
        ];

        $kepsek = \App\Models\User::where('jenis_ptk', 'kepala_sekolah')->first();
        $kepalaSekolah = (object)[
            'nama' => $kepsek ? trim(($kepsek->gelar_depan ? $kepsek->gelar_depan.' ' : '').$kepsek->nama.(!empty($kepsek->gelar_belakang) ? ', '.$kepsek->gelar_belakang : '')) : null,
            'nip' => $kepsek->nip ?? null,
        ];

        return view('rapor.semester', [
            'student' => $student,
            'semester' => $semester,
            'school' => $school,
            'class' => $class,
            'fase' => $fase,
            'reportDate' => $reportDate,
            'subjects' => $subjects,
            'ekstra' => $ekstra,
            'attendance' => $attendance,
            'note' => $note,
            'promotion' => $promotion,
            'waliKelas' => $waliKelas,
            'kepalaSekolah' => $kepalaSekolah,
        ]);
    }

    public function pdf(Student $student, Semester $semester)
    {
        // 1) Kelas siswa
        $class = $student->class()->with(['wali'])->first();

        // 2) Data sekolah
        $school = School::first();

        // 3) Tanggal rapor semester (final_report_date)
        $reportDate = DB::table('report_dates')
            ->where('semester_id', $semester->id)
            ->where('class_id', $class->id ?? 0)
            ->value('final_report_date');

        // 4) Ambil semua mapel di kelas & semester ini (urut by order_no)
        $classSubjects = ClassSubject::query()
            ->where('semester_id', $semester->id)
            ->where('class_id', $class->id)
            ->with('subject')
            ->orderBy('order_no')
            ->get();

        // 5) Ambil nilai akhir (final_grades) untuk siswa ini
        $finalGrades = FinalGrade::query()
            ->where('student_id', $student->id)
            ->whereIn('class_subject_id', $classSubjects->pluck('id'))
            ->get()
            ->keyBy('class_subject_id');

        // 6) Rakit data mata pelajaran dengan nilai akhir dan capaian kompetensi
        $subjects = $classSubjects->map(function ($cs) use ($finalGrades) {
            $fg = $finalGrades->get($cs->id);
            $namaMapel = $cs->subject->name ?? $cs->subject->nama_mapel ?? '-';

            return [
                'nama_mapel' => $namaMapel,
                'nilai_akhir' => $fg ? round($fg->final_score, 0) : null,
                'capaian' => $this->generateCapaianKompetensi($fg ? $fg->final_score : null, $namaMapel),
            ];
        });

        // 7) Ekstrakurikuler
        $ekstra = DB::table('extracurricular_assessments as ea')
            ->join('extracurriculars as e', 'e.id', '=', 'ea.extracurricular_id')
            ->where('ea.student_id', $student->id)
            ->where('ea.semester_id', $semester->id)
            ->select('e.name as nama', 'ea.final_grade as predikat', 'ea.final_description as keterangan')
            ->get();

        // 8) Absensi
        $attendance = Attendance::where('student_id', $student->id)
            ->where('semester_id', $semester->id)
            ->first();

        // 9) Catatan wali kelas
        $note = Note::where('student_id', $student->id)
            ->where('semester_id', $semester->id)
            ->first();

        // 10) Keputusan kenaikan kelas
        $promotion = Promotion::where('student_id', $student->id)
            ->where('semester_id', $semester->id)
            ->first();

        // 11) Fase (dari kelas)
        $fase = $class->fase ?? 'F';

        // 12) Wali kelas dan kepala sekolah dengan gelar lengkap
        $wali = $class->wali ?? null;
        $waliKelas = (object)[
            'nama' => $wali ? trim(($wali->gelar_depan ? $wali->gelar_depan.' ' : '').$wali->nama.(!empty($wali->gelar_belakang) ? ', '.$wali->gelar_belakang : '')) : null,
            'nip' => $wali->nip ?? null,
        ];

        $kepsek = \App\Models\User::where('jenis_ptk', 'kepala_sekolah')->first();
        $kepalaSekolah = (object)[
            'nama' => $kepsek ? trim(($kepsek->gelar_depan ? $kepsek->gelar_depan.' ' : '').$kepsek->nama.(!empty($kepsek->gelar_belakang) ? ', '.$kepsek->gelar_belakang : '')) : null,
            'nip' => $kepsek->nip ?? null,
        ];

        // Render view to HTML
        $html = view('rapor.semester', [
            'student' => $student,
            'semester' => $semester,
            'school' => $school,
            'class' => $class,
            'fase' => $fase,
            'reportDate' => $reportDate,
            'subjects' => $subjects,
            'ekstra' => $ekstra,
            'attendance' => $attendance,
            'note' => $note,
            'promotion' => $promotion,
            'waliKelas' => $waliKelas,
            'kepalaSekolah' => $kepalaSekolah,
        ])->render();

        // Generate PDF
        return PDF::loadHTML($html)
            ->setOption('page-width',  '210mm')
            ->setOption('page-height', '330mm')
            ->setOption('margin-top',     '12mm')
            ->setOption('margin-right',   '12mm')
            ->setOption('margin-bottom',  '12mm')
            ->setOption('margin-left',    '12mm')
            ->setOption('encoding', 'utf-8')
            ->setOption('print-media-type', true)
            ->setOption('disable-smart-shrinking', true)
            ->setOption('enable-local-file-access', true)
            ->setOption('dpi', 96)
            ->inline('Rapor_Semester_'.$student->nama.'_'.$semester->tahun_ajaran.'.pdf');
    }

    private function generateCapaianKompetensi($nilaiAkhir, $namaMapel)
    {
        if (is_null($nilaiAkhir)) {
            return 'Belum ada penilaian';
        }

        $predikat = '';
        if ($nilaiAkhir >= 90) {
            $predikat = 'Menunjukkan penguasaan yang sangat baik';
        } elseif ($nilaiAkhir >= 80) {
            $predikat = 'Menunjukkan penguasaan yang baik';
        } elseif ($nilaiAkhir >= 70) {
            $predikat = 'Menunjukkan penguasaan';
        } else {
            $predikat = 'Menunjukkan penguasaan yang masih perlu ditingkatkan';
        }

        // Template capaian berdasarkan mapel
        $deskripsi = $this->getDeskripsiMapel($namaMapel);

        return $predikat . ' dalam ' . $deskripsi;
    }

    private function getDeskripsiMapel($namaMapel)
    {
        // Template deskripsi default berdasarkan nama mapel
        // Nanti bisa disesuaikan dengan kebutuhan sekolah
        $templates = [
            'Pendidikan Agama Islam' => 'menjelaskan isi kandungan ayat Al-Quran dan hadis dalam kehidupan sehari-hari',
            'Pendidikan Pancasila' => 'peserta didik mampu menerapkan nilai-nilai pancasila dalam kehidupan sehari-hari',
            'Bahasa Indonesia' => 'siswa dapat melakukan resensi dan menulis karya ilmiah',
            'Matematika' => 'siswa dapat menyelesaikan berbagai permasalahan matematika',
            'Bahasa Inggris' => 'siswa mampu berpartisipasi aktif dalam diskusi dengan menyampaikan argumen dalam bahasa Inggris',
            'Sejarah' => 'peserta didik mampu mengaitkan hubungan antara peristiwa sejarah Lokal, Nasional, bahkan Global',
        ];

        // Cari template yang sesuai (case insensitive, partial match)
        foreach ($templates as $key => $value) {
            if (stripos($namaMapel, $key) !== false) {
                return $value;
            }
        }

        // Default template
        return 'mencapai kompetensi mata pelajaran ' . strtolower($namaMapel);
    }
}
