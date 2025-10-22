<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    public function index(Request $r)
    {
        $q = trim((string)$r->get('q'));
        $rows = Subject::when($q, fn($x)=>$x->where(function($w) use ($q){
                $w->where('name','like',"%$q%")->orWhere('short_name','like',"%$q%");
            }))
            ->orderBy('short_name')->paginate(15)->withQueryString();

        return view('subjects.index', compact('rows','q'));
    }

    public function create(){ return view('subjects.create'); }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name'=>['required','string','max:150'],
            'short_name'=>['required','string','max:20','unique:subjects,short_name'],
            'group'=>['nullable','string','max:50'],
            'global_active'=>['nullable','boolean'],
        ]);
        $data['global_active'] = $r->boolean('global_active');
        Subject::create($data);
        return redirect()->route('subjects.index')->with('ok','Mapel dibuat.');
    }

    public function edit(Subject $subject){ return view('subjects.edit', ['row'=>$subject]); }

    public function update(Request $r, Subject $subject)
    {
        $data = $r->validate([
            'name'=>['required','string','max:150'],
            'short_name'=>['required','string','max:20', Rule::unique('subjects','short_name')->ignore($subject->id)],
            'group'=>['nullable','string','max:50'],
            'global_active'=>['nullable','boolean'],
        ]);
        $data['global_active'] = $r->boolean('global_active');
        $subject->update($data);
        return redirect()->route('subjects.index')->with('ok','Mapel diperbarui.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return back()->with('ok','Mapel dihapus.');
    }
}
