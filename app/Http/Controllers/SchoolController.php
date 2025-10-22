<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Semester;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function show(School $school)
    {
        $activeSemester = $school->semesters()->active()->first();
        $semesters = $school->semesters()->orderByDesc('id')->get();

        return view('schools.show', compact('school','activeSemester','semesters'));
    }

    public function edit(School $school)
    {
        return view('schools.edit', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        $data = $request->validate([
            'nama_sekolah'=>'required|string|max:200',
            'email'=>'required|email|max:150',
            'website'=>'nullable|url|max:200',
            'telepon'=>'nullable|string|max:30',
            'alamat_jalan'=>'required|string|max:200',
            'desa_kelurahan'=>'required|string|max:100',
            'kecamatan'=>'required|string|max:100',
            'kabupaten_kota'=>'required|string|max:100',
            'provinsi'=>'required|string|max:100',
            'kode_pos'=>'nullable|string|max:10',
            'npsn'=>'required|string|max:10',
            'nss'=>'nullable|string|max:20',
        ]);
        $school->update($data);
        return back()->with('ok','Profil sekolah diperbarui.');
    }
}
