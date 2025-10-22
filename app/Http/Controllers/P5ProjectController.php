<?php
namespace App\Http\Controllers;

use App\Models\{P5Project,School,Semester,SchoolClass,User};
use Illuminate\Http\Request;

class P5ProjectController extends Controller
{
    public function index(Request $r)
    {
        $semesterId = $r->get('semester_id');
        $classId    = $r->get('class_id');

        $rows = P5Project::with(['class','semester','mentor'])
            ->withCount('criteria') // <- menambah $r->criteria_count
            ->when($semesterId, fn($q)=>$q->where('semester_id',$semesterId))
            ->when($classId, fn($q)=>$q->where('class_id',$classId))
            ->orderByDesc('id')->paginate(15)->withQueryString();


        $semesters = Semester::orderByDesc('id')->get()
            ->mapWithKeys(fn($s)=>[$s->id=>$s->tahun_ajaran.' ('.$s->semester.')']);
        $classes   = SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id');

        return view('p5.projects.index', compact('rows','semesters','classes','semesterId','classId'));
    }

    public function create()
    {
        return view('p5.projects.create', [
            'schools'   => School::orderBy('nama_sekolah')->pluck('nama_sekolah','id'),
            'semesters' => Semester::orderByDesc('id')->get()
                              ->mapWithKeys(fn($s)=>[$s->id=>$s->tahun_ajaran.' ('.$s->semester.')']),
            'classes'   => SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id'),
            'mentors'   => User::orderBy('nama')->pluck('nama','id'),
        ]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'school_id'        => ['required','exists:schools,id'],
            'semester_id'      => ['required','exists:semesters,id'],
            'class_id'         => ['required','exists:classes,id'],
            'theme'            => ['required','string','max:150'],
            'subelement_count' => ['required','integer','min:0'],
            'mentor_id'        => ['nullable','exists:users,id'],
            'active'           => ['nullable','boolean'],
        ]);
        $data['active'] = $r->boolean('active');
        $p = P5Project::create($data);
        return redirect()->route('p5-projects.edit',$p)->with('ok','Projek dibuat.');
    }

    public function edit(P5Project $p5Project)
    {
        return view('p5.projects.edit', [
            'row'=>$p5Project->load(['class','semester','mentor']),
            'schools'   => \App\Models\School::orderBy('nama_sekolah')->pluck('nama_sekolah','id'),
            'semesters' => \App\Models\Semester::orderByDesc('id')->get()
                              ->mapWithKeys(fn($s)=>[$s->id=>$s->tahun_ajaran.' ('.$s->semester.')']),
            'classes'   => \App\Models\SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id'),
            'mentors'   => \App\Models\User::orderBy('nama')->pluck('nama','id'),
        ]);
    }

    public function update(Request $r, P5Project $p5Project)
    {
        $data = $r->validate([
            'school_id'        => ['required','exists:schools,id'],
            'semester_id'      => ['required','exists:semesters,id'],
            'class_id'         => ['required','exists:classes,id'],
            'theme'            => ['required','string','max:150'],
            'subelement_count' => ['required','integer','min:0'],
            'mentor_id'        => ['nullable','exists:users,id'],
            'active'           => ['nullable','boolean'],
        ]);
        $data['active'] = $r->boolean('active');
        $p5Project->update($data);
        return back()->with('ok','Projek diperbarui.');
    }

    public function destroy(P5Project $p5Project)
    {
        $p5Project->delete();
        return back()->with('ok','Projek dihapus.');
    }

    public function toggle(P5Project $p5)
    {
        $p5->update(['active'=>!$p5->active]);
        return back()->with('ok','Status projek diubah.');
    }
}
