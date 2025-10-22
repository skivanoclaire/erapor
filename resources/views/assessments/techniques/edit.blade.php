@extends('layouts.app')
@section('title', 'Edit Teknik Penilaian')

@section('content')
    <form method="POST" action="{{ route('assessment-techniques.update', $row) }}"
        class="bg-white rounded-lg shadow p-4 max-w-xl">
        @csrf
        @method('PUT')

        <h2 class="font-semibold mb-2">Edit Teknik Penilaian</h2>
        @if ($errors->any())
            <div class="mb-3 rounded border border-rose-200 bg-rose-50 text-rose-800 px-3 py-2 text-sm">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <label class="text-sm block mb-3">Sekolah
            <select name="school_id" class="mt-1 w-full border rounded px-3 py-2">
                @foreach ($schools as $id => $nama)
                    <option value="{{ $id }}" @selected(old('school_id', $row->school_id) == $id)>{{ $nama }}</option>
                @endforeach
            </select>
        </label>

        <label class="text-sm block mb-3">Short
            <input name="short_name" value="{{ old('short_name', $row->short_name) }}"
                class="mt-1 w-full border rounded px-3 py-2" maxlength="20" placeholder="tulis / proy / prak">
        </label>

        <label class="text-sm block mb-4">Nama
            <input name="name" value="{{ old('name', $row->name) }}" class="mt-1 w-full border rounded px-3 py-2"
                maxlength="100" placeholder="Tes Tertulis / Proyek / Praktik">
        </label>

        <div class="mt-2 flex gap-2">
            <button class="rounded bg-blue-600 text-white px-4 py-2 hover:bg-blue-700">Simpan</button>
            <a href="{{ route('assessment-techniques.index') }}"
                class="px-4 py-2 rounded border hover:bg-slate-50">Batal</a>
        </div>
    </form>
@endsection
