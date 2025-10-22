@extends('layouts.app')
@section('title', 'Edit Tujuan PKL')

@section('content')
    <form method="POST" action="{{ route('pkl-objectives.update', $row) }}" class="bg-white rounded-lg shadow p-4 max-w-3xl">
        @csrf
        @method('PUT')

        <div class="flex items-start justify-between mb-3">
            <h2 class="font-semibold">Edit Tujuan PKL</h2>
            <a href="{{ route('pkl-objectives.index') }}" class="text-blue-600 text-sm hover:underline">← Kembali</a>
        </div>

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

        <div class="grid sm:grid-cols-3 gap-4">
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
        </div>

        <label class="block text-sm mt-3">Judul
            <input name="title" value="{{ old('title', $row->title) }}" class="mt-1 w-full border rounded px-3 py-2"
                maxlength="200">
        </label>

        <label class="block text-sm mt-3">Deskripsi
            <textarea name="description" rows="4" class="mt-1 w-full border rounded px-3 py-2">{{ old('description', $row->description) }}</textarea>
        </label>

        <div class="mt-4 flex gap-2">
            <button class="rounded bg-blue-600 text-white px-4 py-2 hover:bg-blue-700">Simpan</button>
            <a href="{{ route('pkl-objectives.index') }}" class="px-4 py-2 border rounded">Batal</a>
        </div>
    </form>
@endsection
