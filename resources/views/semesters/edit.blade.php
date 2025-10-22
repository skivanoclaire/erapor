@extends('layouts.app')
@section('title', 'Edit Semester')
@section('content')
    <form method="POST" action="{{ route('semesters.update', $semester) }}" class="bg-white rounded-lg shadow p-4 max-w-xl">
        @csrf @method('PUT')
        <h2 class="font-semibold mb-4">Edit Semester</h2>
        <div class="grid gap-4">
            <label class="text-sm">Tahun Ajaran
                <input name="tahun_ajaran" value="{{ old('tahun_ajaran', $semester->tahun_ajaran) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Semester
                <select name="semester" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="ganjil" @selected($semester->semester === 'ganjil')>Ganjil</option>
                    <option value="genap" @selected($semester->semester === 'genap')>Genap</option>
                </select>
            </label>
            <label class="text-sm">Status
                <select name="status" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="berjalan" @selected($semester->status === 'berjalan')>Berjalan</option>
                    <option value="tidak_berjalan" @selected($semester->status === 'tidak_berjalan')>Tidak Berjalan</option>
                </select>
            </label>
        </div>
        <div class="mt-4 flex gap-2">
            <button class="rounded bg-blue-600 text-white px-4 py-2 hover:bg-blue-700">Simpan</button>
            <a href="{{ route('semesters.index') }}" class="px-4 py-2 rounded border">Batal</a>
        </div>
    </form>
@endsection
