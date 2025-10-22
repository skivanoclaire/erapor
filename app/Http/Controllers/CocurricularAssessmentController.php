<?php
namespace App\Http\Controllers;

use App\Models\{CocurricularActivity,CocurricularMember,CocurricularAssessment,Student};
use Illuminate\Http\Request;

class CocurricularAssessmentController extends Controller
{
    private array $grades = ['Sangat Baik','Baik','Cukup','Kurang','-'];

    public function index(CocurricularActivity $co)
    {
        $memberIds = CocurricularMember::where('cocurricular_id',$co->id)->pluck('student_id');
        $students  = Student::whereIn('id',$memberIds)->orderBy('nama')->get(['id','nama']);

        $map = CocurricularAssessment::where('cocurricular_id',$co->id)
                ->get()->keyBy('student_id');

        return view('cocurriculars.assess', [
            'co'=>$co, 'students'=>$students, 'map'=>$map, 'grades'=>$this->grades
        ]);
    }

    public function store(CocurricularActivity $co, Request $r)
    {
        foreach ($r->get('ids',[]) as $sid) {
            CocurricularAssessment::updateOrCreate(
                ['cocurricular_id'=>$co->id,'student_id'=>$sid],
                [
                    'grade'       => $r->input("grade.$sid"),
                    'description' => $r->input("desc.$sid"),
                ]
            );
        }
        return back()->with('ok','Penilaian kokurikuler disimpan.');
    }
}
