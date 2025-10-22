<?php
namespace App\Http\Controllers;

use App\Models\{PKLGroup,PKLGroupMember,PKLAssessment,Student};
use Illuminate\Http\Request;

class PKLAssessmentController extends Controller
{
    private array $grades = ['Sangat Baik','Baik','Cukup','Kurang','-'];

    public function index(PKLGroup $group)
    {
        $memberIds = PKLGroupMember::where('pkl_group_id',$group->id)->pluck('student_id');
        $students = Student::whereIn('id',$memberIds)->orderBy('nama')->get(['id','nama']);
        $map = PKLAssessment::where('pkl_group_id',$group->id)->get()->keyBy('student_id');

        return view('pkl.assess.index', [
            'group'=>$group, 'students'=>$students, 'map'=>$map, 'grades'=>$this->grades
        ]);
    }

    public function store(PKLGroup $group, Request $r)
    {
        foreach ($r->get('ids',[]) as $sid) {
            PKLAssessment::updateOrCreate(
                ['pkl_group_id'=>$group->id,'student_id'=>$sid],
                [
                    'grade'       => $r->input("grade.$sid"),
                    'description' => $r->input("desc.$sid"),
                ]
            );
        }
        return back()->with('ok','Nilai PKL disimpan.');
    }
}
