<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SchoolHeadController extends Controller
{
    public function edit($id)
    {
        // Ambil user dengan jenis_ptk = kepala_sekolah
        $head = User::where('jenis_ptk', 'kepala_sekolah')->firstOrFail();
        return view('school_heads.edit', ['head' => $head]);
    }

    public function update(Request $request, $id)
    {
        // Update user kepala sekolah
        $head = User::where('jenis_ptk', 'kepala_sekolah')->firstOrFail();

        $data = $request->validate([
            'nip' => 'nullable|string|max:30',
            'gelar_depan' => 'nullable|string|max:50',
            'nama' => 'required|string|max:150',
            'gelar_belakang' => 'nullable|string|max:50',
        ]);

        $head->update($data);
        return back()->with('ok', 'Data kepala sekolah disimpan.');
    }
}
