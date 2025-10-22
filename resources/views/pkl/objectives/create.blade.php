@extends('layouts.app')
@section('title', 'Tambah Tujuan PKL')

@section('content')
    <form method="POST" action="{{ route('pkl-objectives.store') }}" class="bg-white rounded-lg shadow p-4 max-w-3xl">
        @csrf
        <h2 class="font-semibold mb-4">Tambah Tujuan PKL</h2>

        <div class="grid sm:grid-cols-3 gap-4">
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
        </div>

        <label class="block text-sm mt-3">Judul
            <input name="title" class="mt-1 w-full border rounded px-3 py-2">
        </label>
        <label class="block text-sm mt-3">Deskripsi
            <textarea name="description" class="mt-1 w-full border rounded px-3 py-2" rows="4"></textarea>
        </label>

        <div class="mt-4">
            <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan</button>
            <a href="{{ route('pkl-objectives.index') }}" class="px-4 py-2 border rounded">Batal</a>
        </div>
    </form>
@endsection
