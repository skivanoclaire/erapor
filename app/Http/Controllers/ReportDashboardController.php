<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StudentReportBuilder;
use App\Models\{
    Student,
    Semester,
    School,
    SchoolHead,
    SchoolClass,            // <- kelas
    ClassSubject,
    SubjectEnrollment,
    FinalGrade,
    ExtracurricularMember,
    ExtracurricularAssessment,
    Attendance,
    Note,
    Promotion,
    ReportSetting,
    ReportWaliSignature,
    MediaUpload            // jika perlu render gambar ttd/logo
};


class ReportDashboardController extends Controller
{
    public function index(Request $r, StudentReportBuilder $builder)
    {
        // Dropdown Semester
        $semesters  = Semester::orderByDesc('id')
                        ->get(['id','tahun_ajaran','semester','school_id']);
        $semesterId = (int) $r->query('semester_id', $semesters->first()->id ?? 0);

        // Dropdown Kelas (berdasarkan sekolah dari semester terpilih)
        $schoolId = optional($semesters->firstWhere('id', $semesterId))->school_id ?? null;

        $classes = $schoolId
            ? SchoolClass::where('school_id', $schoolId)
                ->orderBy('nama_kelas')->get(['id','nama_kelas'])
            : collect();

        $classId = (int) $r->query('class_id', 0);

        // Dropdown Siswa (berdasarkan kelas terpilih)
        $students = $classId
            ? Student::where('class_id', $classId)
                ->orderBy('nama')->get(['id','nama'])
            : collect();

        $studentId = (int) $r->query('student_id', 0);

        // Data rapor (hasil join) jika semester & siswa sudah dipilih
        $data = ($semesterId && $studentId)
            ? $builder->build($studentId, $semesterId)
            : null;

        return view('reports.dashboard', compact(
            'semesters','semesterId','classes','classId','students','studentId','data'
        ));
    }
}
