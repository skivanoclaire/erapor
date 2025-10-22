@extends('layouts.app')
@section('title', 'Edit Kustom Font')

@section('content')
    <form method="POST" action="{{ route('rc.update', $row) }}" class="bg-white rounded-lg shadow p-4 max-w-3xl">
        @csrf @method('PUT')
        <h2 class="font-semibold mb-4">Edit Kustom Font</h2>

        @if (session('ok'))
            <div class="mb-3 rounded border border-emerald-200 bg-emerald-50 text-emerald-800 px-3 py-2 text-sm">
                {{ session('ok') }}</div>
        @endif
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
                    <option value="{{ $id }}" @selected(old('school_id', $row->school_id) == $id)>{{ $n }}</option>
                @endforeach
            </select>
        </label>

        <div class="grid sm:grid-cols-2 gap-4">
            <label class="text-sm">Berlaku untuk
                <select name="apply_to" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach (['Rapor Tengah Semester', 'Rapor Akhir Semester'] as $opt)
                        <option value="{{ $opt }}" @selected(old('apply_to', $row->apply_to) == $opt)>{{ $opt }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm">Font family
                <input name="font_family" list="font_list" class="mt-1 w-full border rounded px-3 py-2"
                    value="{{ old('font_family', $row->font_family) }}">
                <datalist id="font_list">
                    <option>Arial</option>
                    <option>Times New Roman</option>
                    <option>Calibri</option>
                    <option>Cambria</option>
                    <option>Verdana</option>
                    <option>Tahoma</option>
                    <option>Georgia</option>
                </datalist>
            </label>

            <label class="text-sm">Ukuran Judul
                <input type="number" step="0.1" min="8" max="48" name="title_font_size"
                    value="{{ old('title_font_size', $row->title_font_size) }}" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Ukuran Header Tabel
                <input type="number" step="0.1" min="8" max="32" name="table_header_font_size"
                    value="{{ old('table_header_font_size', $row->table_header_font_size) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Ukuran Isi Tabel
                <input type="number" step="0.1" min="8" max="32" name="table_body_font_size"
                    value="{{ old('table_body_font_size', $row->table_body_font_size) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
        </div>

        <div class="mt-4">
            <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan</button>
            <a href="{{ route('rc.index') }}" class="px-4 py-2 border rounded">Batal</a>
        </div>
    </form>
@endsection
