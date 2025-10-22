<?php

namespace App\Http\Controllers;

use App\Models\AssessmentPlan;
use App\Models\ClassSubject;
use Illuminate\Http\Request;

class AssessmentPlanController extends Controller
{
    public function edit(ClassSubject $cs)
    {
        $plan = AssessmentPlan::firstOrCreate(
            ['class_subject_id' => $cs->id],
            [
                'planned_formatif'   => 0,
                'planned_sumatif'    => 0,
                'planned_sumatif_as' => 0,
                // default bobot aman (1-1-1)
                'weight_formatif'    => 1.00,
                'weight_sumatif'     => 1.00,
                'weight_sumatif_as'  => 1.00,
            ]
        );

        return view('assessments.plans.edit', compact('cs','plan'));
    }

    public function update(Request $r, ClassSubject $cs)
    {
        $data = $r->validate([
            'planned_formatif'   => ['required','integer','min:0'],
            'planned_sumatif'    => ['required','integer','min:0'],
            'planned_sumatif_as' => ['required','integer','min:0'],
            'weight_formatif'    => ['required','numeric','min:0'],
            'weight_sumatif'     => ['required','numeric','min:0'],
            'weight_sumatif_as'  => ['required','numeric','min:0'],
        ]);

        AssessmentPlan::updateOrCreate(['class_subject_id' => $cs->id], $data);

        return back()->with('ok','Rencana penilaian & bobot disimpan.');
    }
}
