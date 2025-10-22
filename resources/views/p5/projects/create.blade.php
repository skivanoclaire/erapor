@extends('layouts.app')
@section('title', 'Tambah Projek P5BK')

@section('content')
    <form method="POST" action="{{ route('p5-projects.store') }}" class="bg-white rounded-lg shadow p-4 max-w-3xl">
        @csrf
        <h2 class="font-semibold mb-4">Tambah Projek</h2>

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
            <label class="text-sm">Mentor
                <select name="mentor_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($mentors as $id => $n)
                        <option value="{{ $id }}">{{ $n }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm sm:col-span-2">Tema
                <input name="theme" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Jumlah Sub-elemen
                <input name="subelement_count" type="number" min="0" value="0"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm inline-flex items-center gap-2 mt-6">
                <input type="checkbox" name="active" value="1" checked> Aktif?
            </label>
        </div>

        <div class="mt-4">
            <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan</button>
            <a href="{{ route('p5-projects.index') }}" class="px-4 py-2 rounded border">Batal</a>
        </div>
    </form>
@endsection
