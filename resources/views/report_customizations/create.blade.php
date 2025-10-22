@extends('layouts.app')
@section('title', 'Tambah Kustom Font')

@section('content')
    <form method="POST" action="{{ route('rc.store') }}" class="bg-white rounded-lg shadow p-4 max-w-3xl">
        @csrf
        <h2 class="font-semibold mb-4">Tambah Kustom Font</h2>

        @if ($errors->any())
            <div class="mb-3 rounded border border-rose-200 bg-rose-50 text-rose-800 px-3 py-2 text-sm">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <label class="block text-sm mb-3">Sekolah
            <select name="school_id" class="mt-1 w-full border rounded px-3 py-2">
                @foreach ($schools as $id => $n)
                    <option value="{{ $id }}">{{ $n }}</option>
                @endforeach
            </select>
        </label>

        <div class="grid sm:grid-cols-2 gap-4">
            <label class="text-sm">Berlaku untuk
                <select name="apply_to" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="Rapor Tengah Semester">Rapor Tengah Semester</option>
                    <option value="Rapor Akhir Semester">Rapor Akhir Semester</option>
                </select>
            </label>
            <label class="text-sm">Font family
                <input name="font_family" list="font_list" class="mt-1 w-full border rounded px-3 py-2" value="Arial">
                <datalist id="font_list">
                    @foreach ($fonts as $f)
                        <option value="{{ $f }}">{{ $f }}</option>
                    @endforeach
                </datalist>
            </label>

            <label class="text-sm">Ukuran Judul
                <input type="number" step="0.1" min="8" max="48" name="title_font_size" value="18"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Ukuran Header Tabel
                <input type="number" step="0.1" min="8" max="32" name="table_header_font_size"
                    value="12" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Ukuran Isi Tabel
                <input type="number" step="0.1" min="8" max="32" name="table_body_font_size"
                    value="12" class="mt-1 w-full border rounded px-3 py-2">
            </label>
        </div>

        <div class="mt-4">
            <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan</button>
            <a href="{{ route('rc.index') }}" class="px-4 py-2 border rounded">Batal</a>
        </div>
    </form>
@endsection
s
