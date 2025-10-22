<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Semester;
use App\Models\ClassSubject;
use App\Models\School;
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
            ->with(['waliKelas']) // relasi ke users (wali_kelas_id)
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
}
