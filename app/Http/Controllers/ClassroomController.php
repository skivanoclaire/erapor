<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index(Request $r)
    {
        $q = trim((string)$r->get('q'));

        $classes = SchoolClass::with(['wali','school'])
            ->withCount('students')
            ->when($q, fn($x)=>$x->where('nama_kelas','like',"%$q%"))
            ->orderBy('tingkat_pendidikan')
            ->orderBy('nama_kelas')
            ->paginate(15)
            ->withQueryString();

        return view('classes.index', compact('classes','q'));
    }

    public function create()
    {
        $schools = School::orderBy('nama_sekolah')->pluck('nama_sekolah','id');
        $walies  = User::orderBy('nama')->pluck('nama','id');

        return view('classes.create', compact('schools','walies'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'school_id'          => ['required','exists:schools,id'],
            'nama_kelas'         => ['required','string','max:100'],
            'jurusan'            => ['nullable','string','max:120'],
            'tingkat_pendidikan' => ['required','string','max:20'], 
            'wali_kelas_id'      => ['nullable','exists:users,id'],
        ]);

        SchoolClass::create($data);
        return redirect()->route('classes.index')->with('ok','Kelas dibuat.');
    }

    public function edit(SchoolClass $class)
    {
        $schools = School::orderBy('nama_sekolah')->pluck('nama_sekolah','id');
        $walies  = User::orderBy('nama')->pluck('nama','id');

        return view('classes.edit', [
            'class'   => $class,
            'schools' => $schools,
            'walies'  => $walies
        ]);
    }

    public function update(Request $r, SchoolClass $class)
    {
        $data = $r->validate([
            'school_id'          => ['required','exists:schools,id'],
            'nama_kelas'         => ['required','string','max:100'],
            'jurusan'            => ['nullable','string','max:120'],
            'tingkat_pendidikan' => ['required','string','max:20'],
            'wali_kelas_id'      => ['nullable','exists:users,id'],
        ]);

        $class->update($data);
        return redirect()->route('classes.index')->with('ok','Kelas diperbarui.');
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();
        return back()->with('ok','Kelas dihapus.');
    }
}
