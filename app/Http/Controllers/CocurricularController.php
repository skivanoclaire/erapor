<?php
namespace App\Http\Controllers;

use App\Models\{CocurricularActivity,School,Semester,SchoolClass,User};
use Illuminate\Http\Request;

class CocurricularController extends Controller
{
    public function index(Request $r)
    {
        $semesterId = $r->get('semester_id');
        $classId    = $r->get('class_id');

        $rows = CocurricularActivity::with(['mentor','class','semester'])
            ->when($semesterId, fn($q)=>$q->where('semester_id',$semesterId))
            ->when($classId, fn($q)=>$q->where('class_id',$classId))
            ->orderBy('name')
            ->paginate(15)->withQueryString();

        $semesters = Semester::orderByDesc('id')->get()
            ->mapWithKeys(fn($s)=>[$s->id=>$s->tahun_ajaran.' ('.$s->semester.')']);
        $classes = SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id');

        return view('cocurriculars.index', compact('rows','semesters','classes','semesterId','classId'));
    }

    public function create()
    {
        return view('cocurriculars.create', [
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
            'school_id'   => ['required','exists:schools,id'],
            'semester_id' => ['required','exists:semesters,id'],
            'class_id'    => ['nullable','exists:classes,id'],
            'name'        => ['required','string','max:200'],
            'dimension'   => ['nullable','string','max:150'],
            'mentor_id'   => ['nullable','exists:users,id'],
            'active'      => ['nullable','boolean'],
        ]);
        $data['active'] = $r->boolean('active');
        CocurricularActivity::create($data);
        return redirect()->route('cocurriculars.index')->with('ok','Kegiatan kokurikuler dibuat.');
    }

    public function edit(CocurricularActivity $cocurricular)
    {
        return view('cocurriculars.edit', [
            'row'       => $cocurricular,
            'schools'   => \App\Models\School::orderBy('nama_sekolah')->pluck('nama_sekolah','id'),
            'semesters' => \App\Models\Semester::orderByDesc('id')->get()
                              ->mapWithKeys(fn($s)=>[$s->id=>$s->tahun_ajaran.' ('.$s->semester.')']),
            'classes'   => \App\Models\SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id'),
            'mentors'   => \App\Models\User::orderBy('nama')->pluck('nama','id'),
        ]);
    }

    public function update(Request $r, CocurricularActivity $cocurricular)
    {
        $data = $r->validate([
            'school_id'   => ['required','exists:schools,id'],
            'semester_id' => ['required','exists:semesters,id'],
            'class_id'    => ['nullable','exists:classes,id'],
            'name'        => ['required','string','max:200'],
            'dimension'   => ['nullable','string','max:150'],
            'mentor_id'   => ['nullable','exists:users,id'],
            'active'      => ['nullable','boolean'],
        ]);
        $data['active'] = $r->boolean('active');
        $cocurricular->update($data);
        return back()->with('ok','Data diperbarui.');
    }

    public function destroy(CocurricularActivity $cocurricular)
    {
        $cocurricular->delete();
        return back()->with('ok','Kegiatan dihapus.');
    }
}
