<?php
namespace App\Http\Controllers;

use App\Models\{PKLLearningObjective,School,Semester,SchoolClass};
use Illuminate\Http\Request;

class PKLObjectiveController extends Controller
{
    public function index(Request $r)
    {
        $rows = PKLLearningObjective::with([])->orderByDesc('id')->paginate(15)->withQueryString();
        return view('pkl.objectives.index', compact('rows'));
    }

    public function create()
    {
        return view('pkl.objectives.create', [
            'schools'=>School::orderBy('nama_sekolah')->pluck('nama_sekolah','id'),
            'semesters'=>Semester::orderByDesc('id')->get()
               ->mapWithKeys(fn($s)=>[$s->id=>$s->tahun_ajaran.' ('.$s->semester.')']),
            'classes'=>SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id'),
        ]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'school_id'   => ['required','exists:schools,id'],
            'semester_id' => ['required','exists:semesters,id'],
            'class_id'    => ['nullable','exists:classes,id'],
            'title'       => ['required','string','max:200'],
            'description' => ['nullable','string'],
        ]);
        PKLLearningObjective::create($data);
        return redirect()->route('pkl-objectives.index')->with('ok','Tujuan PKL dibuat.');
    }

    public function edit(PKLLearningObjective $pkl_objective)
    {
        return view('pkl.objectives.edit', [
            'row'=>$pkl_objective,
            'schools'=>\App\Models\School::orderBy('nama_sekolah')->pluck('nama_sekolah','id'),
            'semesters'=>\App\Models\Semester::orderByDesc('id')->get()
               ->mapWithKeys(fn($s)=>[$s->id=>$s->tahun_ajaran.' ('.$s->semester.')']),
            'classes'=>\App\Models\SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id'),
        ]);
    }

    public function update(Request $r, PKLLearningObjective $pkl_objective)
    {
        $data = $r->validate([
            'school_id'   => ['required','exists:schools,id'],
            'semester_id' => ['required','exists:semesters,id'],
            'class_id'    => ['nullable','exists:classes,id'],
            'title'       => ['required','string','max:200'],
            'description' => ['nullable','string'],
        ]);
        $pkl_objective->update($data);
        return back()->with('ok','Tujuan PKL diperbarui.');
    }

    public function destroy(PKLLearningObjective $pkl_objective)
    {
        $pkl_objective->delete();
        return back()->with('ok','Tujuan PKL dihapus.');
    }
}
