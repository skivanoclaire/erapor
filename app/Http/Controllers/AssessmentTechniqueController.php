<?php

namespace App\Http\Controllers;

use App\Models\AssessmentTechnique;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AssessmentTechniqueController extends Controller
{
    public function index(Request $r)
    {
        $q = trim((string)$r->get('q'));
        $rows = AssessmentTechnique::when($q, fn($x)=>$x->where(function($w) use($q){
                $w->where('name','like',"%$q%")->orWhere('short_name','like',"%$q%");
            }))
            ->orderBy('short_name')->paginate(15)->withQueryString();
        return view('assessments.techniques.index', compact('rows','q'));
    }

    public function create()
    {
        $schools = School::orderBy('nama_sekolah')->pluck('nama_sekolah','id');
        return view('assessments.techniques.create', compact('schools'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'school_id'=>['required','exists:schools,id'],
            'name'=>['required','string','max:100'],
            'short_name'=>['required','string','max:20',
                Rule::unique('assessment_techniques')->where('school_id',$r->school_id)],
        ]);
        AssessmentTechnique::create($data);
        return redirect()->route('assessment-techniques.index')->with('ok','Teknik dibuat.');
    }

    public function edit(AssessmentTechnique $assessmentTechnique)
    {
        $schools = School::orderBy('nama_sekolah')->pluck('nama_sekolah','id');
        return view('assessments.techniques.edit', ['row'=>$assessmentTechnique,'schools'=>$schools]);
    }

    public function update(Request $r, AssessmentTechnique $assessmentTechnique)
    {
        $data = $r->validate([
            'school_id'=>['required','exists:schools,id'],
            'name'=>['required','string','max:100'],
            'short_name'=>['required','string','max:20',
                Rule::unique('assessment_techniques')->ignore($assessmentTechnique->id)
                    ->where('school_id',$r->school_id)],
        ]);
        $assessmentTechnique->update($data);
        return redirect()->route('assessment-techniques.index')->with('ok','Teknik diperbarui.');
    }

    public function destroy(AssessmentTechnique $assessmentTechnique)
    {
        $assessmentTechnique->delete();
        return back()->with('ok','Teknik dihapus.');
    }
}
