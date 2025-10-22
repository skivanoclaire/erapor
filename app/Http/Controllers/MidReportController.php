<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Semester;
use App\Models\School;
use App\Models\SchoolHead;
use App\Models\SchoolClass;
use App\Models\ClassSubject;
use App\Models\Attendance;
use App\Models\ReportDate;
use App\Models\User;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MidReportController extends Controller
{
    public function show($studentId, $semesterId, Request $r)
    {
        [$student, $semester, $class, $school] = $this->loadCore($studentId, $semesterId);

        $rows   = $this->loadMidScores($class->id, $semester->id, $student->id);
        $ekstra = $this->loadExtracurricular($student->id, $semester->id);

        $att = Attendance::where('student_id', $student->id)
            ->where('semester_id', $semester->id)
            ->first();

        $dateRow    = ReportDate::where('class_id', $class->id)->where('semester_id', $semester->id)->first();
        $reportDate = $dateRow?->mid_report_date;

        $wali     = $class->wali ?? User::find($class->wali_kelas_id);
        $waliNama = $wali->nama ?? null;
        $waliNip  = $wali->nip  ?? null;

        $kepsek     = SchoolHead::where('school_id', $school->id)->first();
        $kepsekNama = trim(($kepsek?->gelar_depan ? $kepsek->gelar_depan.' ' : '').($kepsek->nama ?? ''));
        if (!empty($kepsek?->gelar_belakang)) $kepsekNama .= ', '.$kepsek->gelar_belakang;
        $kepsekNip  = $kepsek->nip ?? null;

        $fase     = $this->computeFase($class);
        $waliNote = '';

        return view('rapor.mid', compact(
            'student','semester','class','school',
            'rows','ekstra','att','reportDate',
            'waliNama','waliNip','kepsekNama','kepsekNip','fase','waliNote'
        ));
    }

    public function pdf($studentId, $semesterId, Request $r)
    {
        [$student, $semester, $class, $school] = $this->loadCore($studentId, $semesterId);

        $rows       = $this->loadMidScores($class->id, $semester->id, $student->id);
        $ekstra     = $this->loadExtracurricular($student->id, $semester->id);
        $att        = Attendance::where('student_id',$student->id)->where('semester_id',$semester->id)->first();
        $dateRow    = ReportDate::where('class_id',$class->id)->where('semester_id',$semester->id)->first();
        $reportDate = $dateRow?->mid_report_date;

        $wali     = $class->wali ?? User::find($class->wali_kelas_id);
        $waliNama = $wali->nama ?? null;
        $waliNip  = $wali->nip  ?? null;

        $kepsek     = SchoolHead::where('school_id',$school->id)->first();
        $kepsekNama = trim(($kepsek?->gelar_depan ? $kepsek->gelar_depan.' ' : '').($kepsek->nama ?? ''));
        if (!empty($kepsek?->gelar_belakang)) $kepsekNama .= ', '.$kepsek->gelar_belakang;
        $kepsekNip  = $kepsek->nip ?? null;

        $fase     = $this->computeFase($class);
        $waliNote = '';

        $html = view('rapor.mid', compact(
            'student','semester','class','school',
            'rows','ekstra','att','reportDate',
            'waliNama','waliNip','kepsekNama','kepsekNip','fase','waliNote'
        ))->render();

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
            ->inline('Tengah_Semester_'.$student->nama.'_'.$semester->tahun_ajaran.'.pdf');
    }

    /** ===== Helpers ===== */

    private function loadCore($studentId, $semesterId): array
    {
        $student  = Student::with(['class.school'])->findOrFail($studentId);
        $semester = Semester::findOrFail($semesterId);
        $class    = $student->class ?? SchoolClass::findOrFail($student->class_id);
        $school   = $class->school ?? School::first();

        return [$student,$semester,$class,$school];
    }

    private function loadMidScores(int $classId, int $semesterId, int $studentId): array
    {
        $rows = [];
        $classSubjects = ClassSubject::with('subject')
            ->where('class_id', $classId)
            ->where('semester_id', $semesterId)
            ->orderBy('order_no', 'asc')
            ->get();

        foreach ($classSubjects as $cs) {
            $scores = DB::table('assessments as a')
                ->join('assessment_scores as s', 's.assessment_id', '=', 'a.id')
                ->where('a.class_subject_id', $cs->id)
                ->where('a.type', 'sumatif')
                ->where('s.student_id', $studentId)
                ->orderBy('a.date')
                ->orderBy('a.id')
                ->limit(5)
                ->pluck('s.score');

            $five = array_pad($scores->toArray(), 5, null);
            $vals = array_values(array_filter($five, fn ($v) => $v !== null));
            $avg  = count($vals) ? array_sum($vals) / count($vals) : null;

            $rows[] = [
                'mapel' => $cs->subject->short_name
                    ?? $cs->subject->nama
                    ?? $cs->subject->nama_mapel
                    ?? 'Mata Pelajaran',
                's'   => $five,
                'avg' => $avg,
            ];
        }

        return $rows;
    }

    /**
     * Ekstrakurikuler Tengah Semester
     * - Sumber nilai: extracurricular_assessments.mid_grade & mid_description
     * - Nama ekskul: extracurriculars.name
     * - Tetap ikutkan assessment yang belum ada membership-nya (edge case)
     */
    private function loadExtracurricular(int $studentId, int $semesterId): array
    {
        // Dari membership (prioritas nilai dari assessments)
        $fromMembers = DB::table('extracurricular_members as em')
            ->join('extracurriculars as e', 'e.id', '=', 'em.extracurricular_id')
            ->leftJoin('extracurricular_assessments as ea', function ($join) use ($semesterId, $studentId) {
                $join->on('ea.extracurricular_id', '=', 'em.extracurricular_id')
                     ->where('ea.semester_id', $semesterId)
                     ->where('ea.student_id', $studentId);
            })
            ->where('em.student_id', $studentId)
            ->where('em.semester_id', $semesterId)
            ->select([
                'e.name as ekskul_name',
                'ea.mid_grade as grade',
                'ea.mid_description as description',
            ])
            ->orderBy('e.name')
            ->get()
            ->map(fn ($r) => [
                'nama'     => $r->ekskul_name ?? '-',
                'predikat' => $r->grade ?? null,
                'ket'      => $r->description ?? null,
            ])
            ->toArray();

        // Assessment tanpa membership (kalau ada)
        $assessOnly = DB::table('extracurricular_assessments as ea')
            ->join('extracurriculars as e', 'e.id', '=', 'ea.extracurricular_id')
            ->leftJoin('extracurricular_members as em', function ($join) use ($semesterId, $studentId) {
                $join->on('em.extracurricular_id', '=', 'ea.extracurricular_id')
                     ->where('em.semester_id', $semesterId)
                     ->where('em.student_id', $studentId);
            })
            ->whereNull('em.id')
            ->where('ea.student_id', $studentId)
            ->where('ea.semester_id', $semesterId)
            ->select([
                'e.name as ekskul_name',
                'ea.mid_grade as grade',
                'ea.mid_description as description',
            ])
            ->orderBy('e.name')
            ->get()
            ->map(fn ($r) => [
                'nama'     => $r->ekskul_name ?? '-',
                'predikat' => $r->grade ?? null,
                'ket'      => $r->description ?? null,
            ])
            ->toArray();

        return array_values(array_merge($fromMembers, $assessOnly));
    }

    /** Fase sederhana: 10->E, 11/12->F */
    private function computeFase($class): ?string
    {
        $t = (int)($class->tingkat_pendidikan ?? 0);
        return $t >= 11 ? 'F' : ($t >= 10 ? 'E' : null);
    }
}
