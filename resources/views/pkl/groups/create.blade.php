@extends('layouts.app')
@section('title', 'Tambah Kelompok PKL')

@section('content')
    <form method="POST" action="{{ route('pkl-groups.store') }}" class="bg-white rounded-lg shadow p-4 max-w-4xl">
        @csrf
        <h2 class="font-semibold mb-4">Tambah Kelompok PKL</h2>

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
            <label class="text-sm">Kelas
                <select name="class_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($classes as $id => $n)
                        <option value="{{ $id }}">{{ $n }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm">Guru Pembimbing
                <select name="pembimbing_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($mentors as $id => $n)
                        <option value="{{ $id }}">{{ $n }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm sm:col-span-2">Tujuan Pembelajaran (opsional)
                <select name="learning_objective_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($objectives as $id => $n)
                        <option value="{{ $id }}">{{ $n }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div class="grid sm:grid-cols-2 gap-4 mt-3">
            <label class="text-sm">Nomor SK Penugasan
                <input name="sk_penugasan" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Tempat PKL
                <input name="tempat_pkl" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Mulai
                <input type="date" name="started_at" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Selesai
                <input type="date" name="ended_at" class="mt-1 w-full border rounded px-3 py-2">
            </label>
        </div>

        <div class="mt-4">
            <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan</button>
            <a href="{{ route('pkl-groups.index') }}" class="px-4 py-2 border rounded">Batal</a>
        </div>
    </form>
@endsection
