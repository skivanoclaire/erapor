<?php
namespace App\Http\Controllers;

use App\Models\{Extracurricular,ExtracurricularMember,ExtracurricularAssessment,Semester,Student};
use Illuminate\Http\Request;

class ExtracurricularAssessmentController extends Controller
{
    private array $grades = ['Sangat Baik','Baik','Cukup','Kurang','-'];

    public function index(Extracurricular $ex, Request $r)
    {
        $semesterId = $r->get('semester_id') ?? Semester::max('id');

        $semesters = Semester::orderByDesc('id')->get()
           ->mapWithKeys(fn($s)=>[$s->id => $s->tahun_ajaran.' ('.$s->semester.')']);

        $memberIds = ExtracurricularMember::where('extracurricular_id',$ex->id)
                       ->where('semester_id',$semesterId)->pluck('student_id');

        $students = Student::whereIn('id',$memberIds)->orderBy('nama')->get(['id','nama']);

        $map = ExtracurricularAssessment::where('extracurricular_id',$ex->id)
                ->where('semester_id',$semesterId)
                ->get()->keyBy('student_id');

        return view('extracurriculars.assess', [
            'ex'=>$ex, 'semesterId'=>$semesterId, 'semesters'=>$semesters,
            'students'=>$students, 'map'=>$map, 'grades'=>$this->grades
        ]);
    }

    public function store(Extracurricular $ex, Request $r)
    {
        $semesterId = $r->validate(['semester_id'=>['required','exists:semesters,id']])['semester_id'];

        foreach ($r->get('ids',[]) as $sid) {
            ExtracurricularAssessment::updateOrCreate(
                ['extracurricular_id'=>$ex->id,'semester_id'=>$semesterId,'student_id'=>$sid],
                [
                    'mid_grade'         => $r->input("mid_grade.$sid"),
                    'mid_description'   => $r->input("mid_desc.$sid"),
                    'final_grade'       => $r->input("final_grade.$sid"),
                    'final_description' => $r->input("final_desc.$sid"),
                ]
            );
        }
        return back()->with('ok','Penilaian ekskul disimpan.');
    }
}
