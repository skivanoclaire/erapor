@extends('layouts.app')
@section('title', 'Edit Kokurikuler')

@section('content')
    <form method="POST" action="{{ route('cocurriculars.update', $row) }}" class="bg-white rounded-lg shadow p-4 max-w-4xl">
        @csrf @method('PUT')

        <div class="flex items-start justify-between mb-3">
            <h2 class="font-semibold">Edit Kegiatan Kokurikuler</h2>
            <div class="flex gap-2">
                <a href="{{ route('co.members', $row) }}"
                    class="px-3 py-2 border rounded hover:bg-slate-50 text-sm">Anggota</a>
                <a href="{{ route('co.assess.index', $row) }}"
                    class="px-3 py-2 border rounded hover:bg-slate-50 text-sm">Nilai</a>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <label class="text-sm">Sekolah
                <select name="school_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($schools as $id => $n)
                        <option value="{{ $id }}" @selected(old('school_id', $row->school_id) == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm">Semester
                <select name="semester_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($semesters as $id => $n)
                        <option value="{{ $id }}" @selected(old('semester_id', $row->semester_id) == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm">Kelas (opsional)
                <select name="class_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($classes as $id => $n)
                        <option value="{{ $id }}" @selected(old('class_id', $row->class_id) == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm">Guru Pembimbing
                <select name="mentor_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($mentors as $id => $n)
                        <option value="{{ $id }}" @selected(old('mentor_id', $row->mentor_id) == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div class="grid sm:grid-cols-2 gap-4 mt-3">
            <label class="text-sm">Nama Kegiatan
                <input name="name" value="{{ old('name', $row->name) }}" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Dimensi (opsional)
                <input name="dimension" value="{{ old('dimension', $row->dimension) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm inline-flex items-center gap-2 mt-2">
                <input type="checkbox" name="active" value="1" @checked(old('active', $row->active))> Aktif?
            </label>
        </div>

        <div class="mt-4 flex gap-2">
            <button class="rounded bg-blue-600 text-white px-4 py-2 hover:bg-blue-700">Simpan</button>
            <a href="{{ route('cocurriculars.index') }}" class="px-4 py-2 border rounded">Batal</a>
        </div>
    </form>
@endsection
