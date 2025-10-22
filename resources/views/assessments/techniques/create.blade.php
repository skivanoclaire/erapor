@extends('layouts.app')
@section('title', 'Tambah Teknik')
@section('content')
    <form method="POST" action="{{ route('assessment-techniques.store') }}" class="bg-white rounded-lg shadow p-4 max-w-xl">
        @csrf
        <h2 class="font-semibold mb-4">Tambah Teknik</h2>
        <label class="text-sm block mb-2">Sekolah
            <select name="school_id" class="mt-1 w-full border rounded px-3 py-2">
                @foreach (\App\Models\School::orderBy('nama_sekolah')->pluck('nama_sekolah', 'id') as $id => $n)
                    <option value="{{ $id }}">{{ $n }}</option>
                @endforeach
            </select>
        </label>
        <label class="text-sm block mb-2">Short
            <input name="short_name" class="mt-1 w-full border rounded px-3 py-2">
        </label>
        <label class="text-sm block mb-2">Nama
            <input name="name" class="mt-1 w-full border rounded px-3 py-2">
        </label>
        <div class="mt-4"><button class="rounded bg-blue-600 text-white px-4 py-2">Simpan</button>
            <a href="{{ route('assessment-techniques.index') }}" class="px-4 py-2 rounded border">Batal</a>
        </div>
    </form>
@endsection
