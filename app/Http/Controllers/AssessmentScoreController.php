<?php

namespace App\Http\Controllers;

use App\Models\{Assessment,AssessmentScore,SubjectEnrollment,Student};
use Illuminate\Http\Request;

class AssessmentScoreController extends Controller
{
    public function edit(Assessment $assessment)
    {
        $cs = $assessment->classSubject;
        // ambil siswa yang ter-enroll
        $students = Student::join('subject_enrollments as se','se.student_id','=','students.id')
            ->where('se.class_subject_id',$cs->id)
            ->orderBy('students.nama')
            ->get(['students.id','students.nama']);

        // skor existing
        $scores = AssessmentScore::where('assessment_id',$assessment->id)->pluck('score','student_id');
        return view('assessments.scores.edit', compact('assessment','cs','students','scores'));
    }

    public function update(Request $r, Assessment $assessment)
    {
        $payload = $r->get('scores', []); // [student_id => score]
        foreach ($payload as $sid => $score) {
            $val = is_null($score) || $score==='' ? null : (float)$score;
            AssessmentScore::updateOrCreate(
                ['assessment_id'=>$assessment->id,'student_id'=>$sid],
                ['score'=>$val]
            );
        }
        return back()->with('ok','Skor disimpan.');
    }
}
