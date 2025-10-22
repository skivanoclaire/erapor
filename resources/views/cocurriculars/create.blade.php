@extends('layouts.app')
@section('title', 'Tambah Kokurikuler')

@section('content')
    <form method="POST" action="{{ route('cocurriculars.store') }}" class="bg-white rounded-lg shadow p-4 max-w-4xl">
        @csrf
        <h2 class="font-semibold mb-4">Tambah Kegiatan Kokurikuler</h2>

        <div class="grid sm:grid-cols-2 gap-4">
            <label class="text-sm">Sekolah
                <select name="school_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($schools as $id => $n)
                        <option value="{{ $id }}">{{ $n }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm">Semester
                <select name="semester_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($semesters as $id => $n)
                        <option value="{{ $id }}">{{ $n }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm">Kelas (opsional)
                <select name="class_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($classes as $id => $n)
                        <option value="{{ $id }}">{{ $n }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm">Guru Pembimbing
                <select name="mentor_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($mentors as $id => $n)
                        <option value="{{ $id }}">{{ $n }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div class="grid sm:grid-cols-2 gap-4 mt-3">
            <label class="text-sm">Nama Kegiatan
                <input name="name" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Dimensi (opsional)
                <input name="dimension" class="mt-1 w-full border rounded px-3 py-2" placeholder="mis: Bernalar Kritis">
            </label>
            <label class="text-sm inline-flex items-center gap-2 mt-2">
                <input type="checkbox" name="active" value="1" checked> Aktif?
            </label>
        </div>

        <div class="mt-4">
            <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan</button>
            <a href="{{ route('cocurriculars.index') }}" class="px-4 py-2 border rounded">Batal</a>
        </div>
    </form>
@endsection
