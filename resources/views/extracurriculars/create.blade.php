@extends('layouts.app')
@section('title', 'Tambah Ekskul')

@section('content')
    <form method="POST" action="{{ route('extracurriculars.store') }}" class="bg-white rounded-lg shadow p-4 max-w-3xl">
        @csrf
        <h2 class="font-semibold mb-4">Tambah Ekskul</h2>

        <label class="text-sm block mb-3">Sekolah
            <select name="school_id" class="mt-1 w-full border rounded px-3 py-2">
                @foreach ($schools as $id => $n)
                    <option value="{{ $id }}">{{ $n }}</option>
                @endforeach
            </select>
        </label>

        <label class="text-sm block mb-3">Nama
            <input name="name" class="mt-1 w-full border rounded px-3 py-2">
        </label>

        <label class="text-sm block mb-3">Mentor
            <select name="mentor_id" class="mt-1 w-full border rounded px-3 py-2">
                <option value="">-</option>
                @foreach ($mentors as $id => $n)
                    <option value="{{ $id }}">{{ $n }}</option>
                @endforeach
            </select>
        </label>

        <label class="text-sm inline-flex items-center gap-2 mb-4">
            <input type="checkbox" name="active" value="1" checked> Aktif?
        </label>

        <div>
            <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan</button>
            <a href="{{ route('extracurriculars.index') }}" class="px-4 py-2 border rounded">Batal</a>
        </div>
    </form>
@endsection
