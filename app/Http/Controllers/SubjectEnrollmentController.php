<?php

namespace App\Http\Controllers;

use App\Models\{ClassSubject,SubjectEnrollment,Student,SchoolClass};
use Illuminate\Http\Request;

class SubjectEnrollmentController extends Controller
{
    public function index(ClassSubject $cs)
    {
        $enrolledIds = $cs->enrollments()->pluck('student_id')->all();

        $enrolled = Student::whereIn('id',$enrolledIds)->orderBy('nama')->get();
        $notYet   = Student::where('class_id',$cs->class_id)->whereNotIn('id',$enrolledIds)
                     ->orderBy('nama')->get();

        return view('enrollments.index', compact('cs','enrolled','notYet'));
    }

    public function enrollAll(ClassSubject $cs)
    {
        $students = Student::where('class_id',$cs->class_id)->pluck('id');
        foreach ($students as $sid) {
            SubjectEnrollment::firstOrCreate([
                'semester_id'=>$cs->semester_id,
                'class_id'=>$cs->class_id,
                'class_subject_id'=>$cs->id,
                'student_id'=>$sid,
            ], [
                'school_id'=>$cs->school_id,
                'participates'=>true,
            ]);
        }
        return back()->with('ok','Semua siswa kelas telah didaftarkan.');
    }

    public function store(Request $r, ClassSubject $cs)
    {
        $r->validate(['student_id'=>['required','exists:students,id']]);

        SubjectEnrollment::firstOrCreate([
            'semester_id'=>$cs->semester_id,
            'class_id'=>$cs->class_id,
            'class_subject_id'=>$cs->id,
            'student_id'=>$r->student_id,
        ], [
            'school_id'=>$cs->school_id,
            'participates'=>true,
        ]);

        return back()->with('ok','Siswa ditambahkan.');
    }

    public function destroy(ClassSubject $cs, $studentId)
    {
        SubjectEnrollment::where([
            'class_subject_id'=>$cs->id,
            'student_id'=>$studentId
        ])->delete();

        return back()->with('ok','Siswa dikeluarkan dari mapel.');
    }
}
