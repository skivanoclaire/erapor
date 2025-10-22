@extends('layouts.app')
@section('title', 'Edit Projek P5BK')

@section('content')
    <form method="POST" action="{{ route('p5-projects.update', $row) }}" class="bg-white rounded-lg shadow p-4 max-w-4xl">
        @csrf
        @method('PUT')

        <div class="flex items-start justify-between mb-3">
            <div>
                <h2 class="font-semibold">Edit Projek P5BK</h2>
                <div class="text-xs text-slate-500">
                    {{ $row->class->nama_kelas ?? '-' }} • {{ $row->semester->tahun_ajaran ?? '' }}
                    ({{ $row->semester->semester ?? '' }})
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('p5.members', $row) }}"
                    class="px-3 py-2 border rounded hover:bg-slate-50 text-sm">Anggota</a>
                <a href="{{ route('p5.criteria', $row) }}"
                    class="px-3 py-2 border rounded hover:bg-slate-50 text-sm">Kriteria</a>
                <a href="{{ route('p5.ratings.index', $row) }}"
                    class="px-3 py-2 border rounded hover:bg-slate-50 text-sm">Nilai</a>
            </div>
        </div>

        {{-- Flash & error --}}
        @if (session('ok'))
            <div class="mb-3 rounded border border-emerald-200 bg-emerald-50 text-emerald-800 px-3 py-2 text-sm">
                {{ session('ok') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-3 rounded border border-rose-200 bg-rose-50 text-rose-800 px-3 py-2 text-sm">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid sm:grid-cols-2 gap-4">
            {{-- Sekolah --}}
            <label class="text-sm">Sekolah
                <select name="school_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($schools as $id => $n)
                        <option value="{{ $id }}" @selected(old('school_id', $row->school_id) == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>

            {{-- Semester --}}
            <label class="text-sm">Semester
                <select name="semester_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($semesters as $id => $label)
                        <option value="{{ $id }}" @selected(old('semester_id', $row->semester_id) == $id)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>

            {{-- Kelas --}}
            <label class="text-sm">Kelas
                <select name="class_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($classes as $id => $n)
                        <option value="{{ $id }}" @selected(old('class_id', $row->class_id) == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>

            {{-- Mentor --}}
            <label class="text-sm">Mentor
                <select name="mentor_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($mentors as $id => $n)
                        <option value="{{ $id }}" @selected(old('mentor_id', $row->mentor_id) == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>

            {{-- Tema --}}
            <label class="text-sm sm:col-span-2">Tema
                <input name="theme" value="{{ old('theme', $row->theme) }}" class="mt-1 w-full border rounded px-3 py-2"
                    maxlength="150">
            </label>

            {{-- Jumlah sub-elemen --}}
            <label class="text-sm">Jumlah Sub-elemen
                <input type="number" name="subelement_count" min="0"
                    value="{{ old('subelement_count', $row->subelement_count) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>

            {{-- Aktif --}}
            <div class="sm:col-span-1 flex items-end">
                <label class="text-sm inline-flex items-center gap-2">
                    <input type="checkbox" name="active" value="1" @checked(old('active', $row->active))> Aktif?
                </label>
            </div>
        </div>

        <div class="mt-4 flex gap-2">
            <button class="rounded bg-blue-600 text-white px-4 py-2 hover:bg-blue-700">Simpan</button>
            <a href="{{ route('p5-projects.index') }}" class="px-4 py-2 rounded border">Batal</a>
        </div>
    </form>
@endsection
