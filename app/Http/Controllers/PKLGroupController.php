<?php
namespace App\Http\Controllers;

use App\Models\{PKLGroup,PKLLearningObjective,School,Semester,SchoolClass,User};
use Illuminate\Http\Request;

class PKLGroupController extends Controller
{
    public function index(Request $r)
    {
        $semesterId = $r->get('semester_id');
        $classId    = $r->get('class_id');

        $rows = PKLGroup::with(['class','semester','mentor','objective'])
            ->when($semesterId, fn($q)=>$q->where('semester_id',$semesterId))
            ->when($classId, fn($q)=>$q->where('class_id',$classId))
            ->orderByDesc('id')->paginate(15)->withQueryString();

        $semesters = \App\Models\Semester::orderByDesc('id')->get()
           ->mapWithKeys(fn($s)=>[$s->id=>$s->tahun_ajaran.' ('.$s->semester.')']);
        $classes = \App\Models\SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id');

        return view('pkl.groups.index', compact('rows','semesters','classes','semesterId','classId'));
    }

    public function create()
    {
        return view('pkl.groups.create', [
            'schools'=>School::orderBy('nama_sekolah')->pluck('nama_sekolah','id'),
            'semesters'=>Semester::orderByDesc('id')->get()
               ->mapWithKeys(fn($s)=>[$s->id=>$s->tahun_ajaran.' ('.$s->semester.')']),
            'classes'=>SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id'),
            'mentors'=>User::orderBy('nama')->pluck('nama','id'),
            'objectives'=>PKLLearningObjective::orderByDesc('id')->pluck('title','id'),
        ]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'school_id'   => ['required','exists:schools,id'],
            'semester_id' => ['required','exists:semesters,id'],
            'class_id'    => ['required','exists:classes,id'],
            'sk_penugasan'=> ['required','string','max:100'],
            'tempat_pkl'  => ['required','string','max:200'],
            'pembimbing_id'=>['nullable','exists:users,id'],
            'learning_objective_id'=>['nullable','exists:pkl_learning_objectives,id'],
            'started_at'  => ['nullable','date'],
            'ended_at'    => ['nullable','date','after_or_equal:started_at'],
        ]);
        PKLGroup::create($data);
        return redirect()->route('pkl-groups.index')->with('ok','Kelompok PKL dibuat.');
    }

    public function edit(PKLGroup $pkl_group)
    {
        return view('pkl.groups.edit', [
            'row'=>$pkl_group,
            'schools'=>\App\Models\School::orderBy('nama_sekolah')->pluck('nama_sekolah','id'),
            'semesters'=>\App\Models\Semester::orderByDesc('id')->get()
               ->mapWithKeys(fn($s)=>[$s->id=>$s->tahun_ajaran.' ('.$s->semester.')']),
            'classes'=>\App\Models\SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id'),
            'mentors'=>\App\Models\User::orderBy('nama')->pluck('nama','id'),
            'objectives'=>PKLLearningObjective::orderByDesc('id')->pluck('title','id'),
        ]);
    }

    public function update(Request $r, PKLGroup $pkl_group)
    {
        $data = $r->validate([
            'school_id'   => ['required','exists:schools,id'],
            'semester_id' => ['required','exists:semesters,id'],
            'class_id'    => ['required','exists:classes,id'],
            'sk_penugasan'=> ['required','string','max:100'],
            'tempat_pkl'  => ['required','string','max:200'],
            'pembimbing_id'=>['nullable','exists:users,id'],
            'learning_objective_id'=>['nullable','exists:pkl_learning_objectives,id'],
            'started_at'  => ['nullable','date'],
            'ended_at'    => ['nullable','date','after_or_equal:started_at'],
        ]);
        $pkl_group->update($data);
        return back()->with('ok','Kelompok PKL diperbarui.');
    }

    public function destroy(PKLGroup $pkl_group)
    {
        $pkl_group->delete();
        return back()->with('ok','Kelompok PKL dihapus.');
    }
}
