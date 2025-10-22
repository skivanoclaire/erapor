<?php
namespace App\Http\Controllers;

use App\Models\{Extracurricular,School,User};
use Illuminate\Http\Request;

class ExtracurricularController extends Controller
{
    public function index(Request $r)
    {
        $q = Extracurricular::with('mentor')->orderBy('name');
        if ($r->filled('active')) $q->where('active', (bool)$r->active);
        $rows = $q->paginate(15)->withQueryString();

        return view('extracurriculars.index', compact('rows'));
    }

    public function create()
    {
        return view('extracurriculars.create', [
            'schools' => School::orderBy('nama_sekolah')->pluck('nama_sekolah','id'),
            'mentors' => User::orderBy('nama')->pluck('nama','id'),
        ]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'school_id' => ['required','exists:schools,id'],
            'name'      => ['required','string','max:150'],
            'mentor_id' => ['nullable','exists:users,id'],
            'active'    => ['nullable','boolean'],
        ]);
        $data['active'] = $r->boolean('active');
        Extracurricular::create($data);
        return redirect()->route('extracurriculars.index')->with('ok','Ekskul dibuat.');
    }

    public function edit(Extracurricular $extracurricular)
    {
        return view('extracurriculars.edit', [
            'row'     => $extracurricular,
            'schools' => \App\Models\School::orderBy('nama_sekolah')->pluck('nama_sekolah','id'),
            'mentors' => \App\Models\User::orderBy('nama')->pluck('nama','id'),
        ]);
    }

    public function update(Request $r, Extracurricular $extracurricular)
    {
        $data = $r->validate([
            'school_id' => ['required','exists:schools,id'],
            'name'      => ['required','string','max:150'],
            'mentor_id' => ['nullable','exists:users,id'],
            'active'    => ['nullable','boolean'],
        ]);
        $data['active'] = $r->boolean('active');
        $extracurricular->update($data);
        return back()->with('ok','Ekskul diperbarui.');
    }

    public function destroy(Extracurricular $extracurricular)
    {
        $extracurricular->delete();
        return back()->with('ok','Ekskul dihapus.');
    }
}
