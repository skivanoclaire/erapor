@extends('layouts.app')
@section('title', 'Tambah User')
@section('content')
    <form method="POST" action="{{ route('users.store') }}" class="bg-white rounded-lg shadow p-4 max-w-3xl">
        @csrf
        <h2 class="font-semibold mb-4">Tambah User</h2>
        <div class="grid sm:grid-cols-2 gap-4">
            <label class="text-sm">Sekolah
                <select name="school_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($schools as $id => $n)
                        <option value="{{ $id }}">{{ $n }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm">Username
                <input name="username" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Password (kosong = "password")
                <input name="password" type="password" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Nama
                <input name="nama" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Jenis PTK
                <select name="jenis_ptk" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach (['guru', 'guru_mapel', 'kepala_sekolah', 'operator', 'pembina', 'pembimbing_pkl'] as $j)
                        <option value="{{ $j }}">{{ $j }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm">Aktif?
                <input type="checkbox" name="ptk_aktif" value="1" class="mt-2" checked>
            </label>
            <label class="text-sm">NIP <input name="nip" class="mt-1 w-full border rounded px-3 py-2"></label>
            <label class="text-sm">NIK <input name="nik" class="mt-1 w-full border rounded px-3 py-2"></label>
            <label class="text-sm">Gelar Depan <input name="gelar_depan"
                    class="mt-1 w-full border rounded px-3 py-2"></label>
            <label class="text-sm">Gelar Belakang <input name="gelar_belakang"
                    class="mt-1 w-full border rounded px-3 py-2"></label>
        </div>
        <div class="mt-4 flex gap-2">
            <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan</button>
            <a href="{{ route('users.index') }}" class="px-4 py-2 rounded border">Batal</a>
        </div>
    </form>
@endsection
