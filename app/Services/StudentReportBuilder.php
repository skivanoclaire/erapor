<?php

namespace App\Services;

use App\Models\{
    Student, Semester, School, SchoolHead, Classes, ClassSubject, FinalGrade, Subject,
    Extracurricular, ExtracurricularAssessments, ExtracurricularMembers, Attendance,
    Notes, ReportSetting, ReportWaliSignature, P5Project, P5ProjectRatings, Promotions
};
use Illuminate\Support\Facades\DB;

class StudentReportBuilder
{
    public function build(int $studentId, int $semesterId): array
    {
        $student  = Student::with(['school','class'])->findOrFail($studentId);
        $semester = \App\Models\Semester::with('school')->findOrFail($semesterId);
        $school   = $semester->school;

        // Setting rapor (opsional; jika tidak ada pakai default)
        $setting  = \App\Models\ReportSetting::where('school_id',$school->id)
                    ->where('semester_id',$semesterId)->first();

        // Kepala sekolah
        $kepala = \App\Models\SchoolHead::where('school_id',$school->id)->latest('id')->first();

        // Mapel & Nilai Akhir (berdasar final_grades)
        $finals = FinalGrade::with(['classSubject.subject'])
            ->where('class_subject_id', function($q) use ($student,$semesterId){
                $q->select('cs.id')->from('class_subjects as cs')
                    ->join('subject_enrollments as se','se.class_subject_id','=','cs.id')
                    ->where('se.student_id',$student->id)
                    ->where('cs.semester_id',$semesterId)
                    ->limit(1);
            })->where('student_id',$student->id)->get(); // fallback jika subquery tak cocok

        // Lebih aman: ambil semua CS semester tsb, lalu map finals
        $classSubjectIds = \App\Models\SubjectEnrollment::where([
            'student_id'=>$student->id,
            'semester_id'=>$semesterId,
        ])->pluck('class_subject_id');

        $classSubjects = \App\Models\ClassSubject::with('subject')
            ->whereIn('id',$classSubjectIds)->orderBy('order_no')->get();

        $finalMap = FinalGrade::whereIn('class_subject_id',$classSubjectIds)
            ->where('student_id',$student->id)
            ->get()->keyBy('class_subject_id');

        $subjects = $classSubjects->map(function($cs) use ($finalMap){
            $fg = $finalMap[$cs->id] ?? null;
            return (object)[
                'class_subject_id' => $cs->id,
                'subject_short'    => $cs->subject->short_name,
                'subject_name'     => $cs->subject->name,
                'final'            => $fg? (float)$fg->final_score : null,
                'desc'             => $this->autoDesc($cs->subject->name, $fg? (float)$fg->final_score : null),
            ];
        })->values();

        // Ekstrakurikuler
        $exMembers = \App\Models\ExtracurricularMember::with(['extracurricular'])
            ->where('semester_id',$semesterId)
            ->where('student_id',$student->id)->get();

        $exAssess  = \App\Models\ExtracurricularAssessment::where('semester_id',$semesterId)
            ->where('student_id',$student->id)->get()->keyBy('extracurricular_id');

        $extracurriculars = $exMembers->map(function($m) use ($exAssess){
            $a = $exAssess[$m->extracurricular_id] ?? null;
            return (object)[
                'name'  => $m->extracurricular->name,
                'grade' => $a? $a->final_grade : null,
                'desc'  => $a? $a->final_description : null,
            ];
        });

        // Absensi
        $att = \App\Models\Attendance::where('semester_id',$semesterId)
            ->where('student_id',$student->id)->first();

        // Catatan wali
        $note = \App\Models\Note::where('semester_id',$semesterId)
            ->where('student_id',$student->id)->first();

        // Keputusan kenaikan
        $prom = \App\Models\Promotion::where('semester_id',$semesterId)
            ->where('student_id',$student->id)->first();

        // Tanda tangan wali per kelas + kepsek
        $waliSig = \App\Models\ReportWaliSignature::with('wali','media')
            ->where('semester_id',$semesterId)
            ->where('class_id', $student->class_id)->first();

        return compact(
            'school','semester','setting','kepala',
            'student','subjects','extracurriculars','att','note','prom','waliSig'
        );
    }

    /** Narasi otomatis sederhana berdasarkan skor */
    private function autoDesc(string $mapel, ?float $score): string
    {
        if ($score === null) return '-';
        $pred = $score >= 90 ? 'sangat baik' : ($score >= 80 ? 'baik' : ($score >= 70 ? 'cukup' : 'perlu bimbingan'));
        return "Menunjukkan penguasaan yang $pred pada mata pelajaran $mapel.";
    }
}
