@extends('layouts.app')
@section('title', 'Tambah Semester Baru')
@section('content')
    <form method="POST" action="{{ route('semesters.store') }}" class="bg-white rounded-lg shadow p-4 max-w-xl">
        @csrf
        <h2 class="font-semibold mb-4">Tambah Semester Baru</h2>

        @if(session('ok'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('ok') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid gap-4">
            <label class="text-sm">Sekolah
                <select name="school_id" class="mt-1 w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Sekolah --</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}" @selected(old('school_id') == $school->id)>
                            {{ $school->nama_sekolah ?? $school->nama }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="text-sm">Tahun Ajaran
                <input name="tahun_ajaran" value="{{ old('tahun_ajaran') }}"
                    placeholder="Contoh: 2024/2025"
                    class="mt-1 w-full border rounded px-3 py-2" required>
                <small class="text-gray-500">Format: 2024/2025 atau 2025/2026</small>
            </label>

            <label class="text-sm">Semester
                <select name="semester" class="mt-1 w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Semester --</option>
                    <option value="1" @selected(old('semester') === '1')>1 (Ganjil)</option>
                    <option value="2" @selected(old('semester') === '2')>2 (Genap)</option>
                </select>
            </label>

            <label class="text-sm">Status
                <select name="status" class="mt-1 w-full border rounded px-3 py-2" required>
                    <option value="tidak_berjalan" @selected(old('status') === 'tidak_berjalan')>Tidak Berjalan</option>
                    <option value="berjalan" @selected(old('status') === 'berjalan')>Berjalan (Aktif)</option>
                </select>
                <small class="text-gray-500">Jika pilih "Berjalan", semester lain akan otomatis dinonaktifkan</small>
            </label>
        </div>

        <div class="mt-4 flex gap-2">
            <button type="submit" class="rounded bg-blue-600 text-white px-4 py-2 hover:bg-blue-700">Simpan</button>
            <a href="{{ route('semesters.index') }}" class="px-4 py-2 rounded border hover:bg-gray-100">Batal</a>
        </div>
    </form>
@endsection
