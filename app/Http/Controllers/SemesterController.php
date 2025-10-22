<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::with('school')->orderByDesc('id')->paginate(15);
        return view('semesters.index', compact('semesters'));
    }

    public function edit(Semester $semester)
    {
        return view('semesters.edit', compact('semester'));
    }

    public function update(Request $request, Semester $semester)
    {
        $data = $request->validate([
            'tahun_ajaran'=>'required|string|max:20',
            'semester'=>'required|in:ganjil,genap',
            'status'=>'required|in:berjalan,tidak_berjalan',
        ]);
        $semester->update($data);
        return back()->with('ok','Semester diperbarui.');
    }

    public function activate(Semester $semester)
    {
        DB::transaction(function () use ($semester) {
            Semester::where('school_id',$semester->school_id)->update(['status'=>'tidak_berjalan']);
            $semester->update(['status'=>'berjalan']);
        });
        return back()->with('ok','Semester diaktifkan.');
    }
}
