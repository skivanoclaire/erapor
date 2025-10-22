<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $r)
    {
        $q = trim((string)$r->get('q'));
        $users = User::with('school')
            ->when($q, fn($x) => $x->where(function($w) use ($q) {
                $w->where('username','like',"%$q%")
                  ->orWhere('nama','like',"%$q%");
            }))
            ->orderBy('id','desc')->paginate(15)->withQueryString();

        return view('users.index', compact('users','q'));
    }

    public function create()
    {
        $schools = School::orderBy('nama_sekolah')->pluck('nama_sekolah','id');
        return view('users.create', compact('schools'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'school_id' => ['required','exists:schools,id'],
            'username'  => ['required','string','max:100','unique:users,username'],
            'password'  => ['nullable','string','min:5'],
            'nama'      => ['required','string','max:150'],
            'jenis_ptk' => ['required', Rule::in(['guru','guru_mapel','kepala_sekolah','operator','pembina','pembimbing_pkl'])],
            'ptk_aktif' => ['nullable','boolean'],
            'nip' => ['nullable','string','max:30'],
            'nik' => ['nullable','string','max:20'],
            'gelar_depan' => ['nullable','string','max:50'],
            'gelar_belakang' => ['nullable','string','max:50'],
        ]);
        $data['ptk_aktif'] = $r->boolean('ptk_aktif');
        $data['password']  = Hash::make($data['password'] ?? 'password');

        User::create($data);
        return redirect()->route('users.index')->with('ok','User dibuat.');
    }

    public function edit(User $user)
    {
        $schools = School::orderBy('nama_sekolah')->pluck('nama_sekolah','id');
        return view('users.edit', compact('user','schools'));
    }

    public function update(Request $r, User $user)
    {
        $data = $r->validate([
            'school_id' => ['required','exists:schools,id'],
            'username'  => ['required','string','max:100', Rule::unique('users','username')->ignore($user->id)],
            'password'  => ['nullable','string','min:5'],
            'nama'      => ['required','string','max:150'],
            'jenis_ptk' => ['required', Rule::in(['guru','guru_mapel','kepala_sekolah','operator','pembina','pembimbing_pkl'])],
            'ptk_aktif' => ['nullable','boolean'],
            'nip' => ['nullable','string','max:30'],
            'nik' => ['nullable','string','max:20'],
            'gelar_depan' => ['nullable','string','max:50'],
            'gelar_belakang' => ['nullable','string','max:50'],
        ]);
        $data['ptk_aktif'] = $r->boolean('ptk_aktif');
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return redirect()->route('users.index')->with('ok','User diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('ok','User dihapus.');
    }
}
