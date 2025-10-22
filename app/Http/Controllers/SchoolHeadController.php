<?php

namespace App\Http\Controllers;

use App\Models\SchoolHead;
use Illuminate\Http\Request;

class SchoolHeadController extends Controller
{
    public function edit(SchoolHead $school_head)
    {
        return view('school_heads.edit', ['head'=>$school_head]);
    }

    public function update(Request $request, SchoolHead $school_head)
    {
        $data = $request->validate([
            'nip'=>'nullable|string|max:30',
            'gelar_depan'=>'nullable|string|max:50',
            'nama'=>'required|string|max:150',
            'gelar_belakang'=>'nullable|string|max:50',
        ]);
        $school_head->update($data);
        return back()->with('ok','Data kepala sekolah disimpan.');
    }
}
