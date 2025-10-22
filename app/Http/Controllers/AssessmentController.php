<?php

namespace App\Http\Controllers;

use App\Models\{Assessment,AssessmentTechnique,AssessmentPlan,ClassSubject,SubjectEnrollment,FinalGrade,AssessmentScore};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\GradeCalculator;

class AssessmentController extends Controller
{
    public function index(ClassSubject $cs)
    {
        $techs = AssessmentTechnique::where('school_id',$cs->school_id)->orderBy('short_name')->get();
        $plan  = AssessmentPlan::firstOrCreate(
            ['class_subject_id'=>$cs->id],
            ['planned_formatif'=>0,'planned_sumatif'=>0,'planned_sumatif_as'=>0]
        );
        $rows  = Assessment::where('class_subject_id',$cs->id)->orderBy('date')->orderBy('id')->get();
        return view('assessments.items.index', compact('cs','rows','techs','plan'));
    }

    public function store(Request $r, ClassSubject $cs)
    {
        $data = $r->validate([
            'title'=>['required','string','max:150'],
            'type'=>['required','in:formatif,sumatif,sumatif_as'],
            'technique_id'=>['nullable','exists:assessment_techniques,id'],
            'date'=>['nullable','date'],
            'max_score'=>['required','numeric','min:1'],
            'weight'=>['required','numeric','min:0.1'],
        ]);
        $data['class_subject_id'] = $cs->id;
        $a = Assessment::create($data);

        // Auto-generate empty scores for yang sudah ter-enroll
        $studentIds = SubjectEnrollment::where('class_subject_id',$cs->id)->pluck('student_id');
        foreach ($studentIds as $sid) {
            AssessmentScore::firstOrCreate(['assessment_id'=>$a->id,'student_id'=>$sid]);
        }

        return back()->with('ok','Penilaian dibuat.');
    }

    public function edit(Assessment $assessment)
    {
        $cs = $assessment->classSubject;
        $techs = AssessmentTechnique::where('school_id',$cs->school_id)->orderBy('short_name')->get();
        return view('assessments.items.edit', compact('assessment','cs','techs'));
    }

    public function update(Request $r, Assessment $assessment)
    {
        $data = $r->validate([
            'title'=>['required','string','max:150'],
            'type'=>['required','in:formatif,sumatif,sumatif_as'],
            'technique_id'=>['nullable','exists:assessment_techniques,id'],
            'date'=>['nullable','date'],
            'max_score'=>['required','numeric','min:1'],
            'weight'=>['required','numeric','min:0.1'],
        ]);
        $assessment->update($data);
        return redirect()->route('assessments.index',$assessment->class_subject_id)->with('ok','Penilaian diperbarui.');
    }

    public function destroy(Assessment $assessment)
    {
        DB::transaction(function() use ($assessment){
            $assessment->scores()->delete();
            $assessment->delete();
        });
        return back()->with('ok','Penilaian dihapus.');
    }

    public function computeFinal(ClassSubject $cs)
    {
        // (score * weight) / sum(weight) per student
        $ass = $cs->load('enrollments')->id;
        $assessments = $cs->hasMany(Assessment::class,'class_subject_id','id')->get(['id','weight']);
        if ($assessments->isEmpty()) return back()->with('ok','Tidak ada penilaian untuk dihitung.');

        $sumWeight = max(1, (float)$assessments->sum('weight'));

        $studentIds = $cs->enrollments()->pluck('student_id')->unique();
        foreach ($studentIds as $sid) {
            $weighted = 0.0;
            foreach ($assessments as $a) {
                $sc = AssessmentScore::where('assessment_id',$a->id)->where('student_id',$sid)->value('score');
                if (!is_null($sc)) $weighted += (float)$sc * (float)$a->weight;
            }
            $final = round($weighted / $sumWeight, 2);
            FinalGrade::updateOrCreate(
                ['class_subject_id'=>$cs->id,'student_id'=>$sid],
                ['final_score'=>$final,'computed_at'=>now()]
            );
        }

        return back()->with('ok','Nilai akhir dihitung.');
    }
}
