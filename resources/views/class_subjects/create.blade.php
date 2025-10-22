@extends('layouts.app')
@section('title', 'Tambah Mapel Kelas')

@section('content')
    <div class="bg-white rounded-lg shadow p-4 max-w-4xl">
        <h2 class="font-semibold mb-3">Tambah Mapel Kelas</h2>

        {{-- Notif error --}}
        @if ($errors->any())
            <div class="mb-3 rounded border border-rose-200 bg-rose-50 text-rose-800 px-3 py-2 text-sm">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 1) Filter kandidat "Gabung dengan" berdasarkan Semester & Kelas --}}
        <form method="GET" action="{{ route('class-subjects.create') }}" class="mb-4 grid sm:grid-cols-3 gap-3">
            <div>
                <label class="text-sm">Semester</label>
                <select name="semester_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">— Pilih —</option>
                    @foreach ($semesters as $id => $label)
                        <option value="{{ $id }}" @selected(($semesterId ?? null) == $id)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm">Kelas</label>
                <select name="class_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">— Pilih —</option>
                    @foreach ($classes as $id => $n)
                        <option value="{{ $id }}" @selected(($classId ?? null) == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button class="px-3 py-2 rounded border">Terapkan Filter</button>
            </div>
        </form>

        {{-- 2) Form utama --}}
        <form method="POST" action="{{ route('class-subjects.store') }}" class="grid sm:grid-cols-2 gap-4">
            @csrf

            {{-- Sekolah --}}
            <label class="text-sm">Sekolah
                <select name="school_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($schools as $id => $n)
                        <option value="{{ $id }}" @selected(old('school_id') == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>

            {{-- Semester (default dari filter jika ada) --}}
            <label class="text-sm">Semester
                <select name="semester_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($semesters as $id => $label)
                        <option value="{{ $id }}" @selected(old('semester_id', $semesterId ?? null) == $id)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>

            {{-- Kelas (default dari filter jika ada) --}}
            <label class="text-sm">Kelas
                <select name="class_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($classes as $id => $n)
                        <option value="{{ $id }}" @selected(old('class_id', $classId ?? null) == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>

            {{-- Mapel --}}
            <label class="text-sm">Mapel
                <select name="subject_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($subjects as $id => $n)
                        <option value="{{ $id }}" @selected(old('subject_id') == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>

            {{-- Guru --}}
            <label class="text-sm">Guru Pengampu
                <select name="teacher_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($teachers as $id => $n)
                        <option value="{{ $id }}" @selected(old('teacher_id') == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>

            {{-- Urutan --}}
            <label class="text-sm">Urutan
                <input name="order_no" type="number" min="1" value="{{ old('order_no', 1) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>

            {{-- Gabung dengan --}}
            <label class="text-sm">Gabung dengan (opsional)
                <select name="combined_with_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @forelse($candidates as $id=>$label)
                        <option value="{{ $id }}" @selected(old('combined_with_id') == $id)>{{ $label }}</option>
                    @empty
                        <option disabled>— Tidak ada kandidat. Pilih Semester & Kelas di filter di atas —</option>
                    @endforelse
                </select>
                <p class="text-xs text-slate-500 mt-1">
                    Pilih mapel lain pada kelas & semester yang sama jika ingin tampil gabungan pada rekap/rapor.
                </p>
            </label>

            {{-- Kelompok override --}}
            <label class="text-sm">Kelompok Override
                <input name="group" value="{{ old('group') }}" class="mt-1 w-full border rounded px-3 py-2"
                    placeholder="mis. Kelompok A (Umum) / C1 / C2 / C3 / Muatan Lokal">
            </label>

            {{-- Aktif --}}
            <div class="sm:col-span-2">
                <label class="text-sm inline-flex items-center gap-2">
                    <input type="checkbox" name="active" value="1" @checked(old('active', true))> Aktif?
                </label>
            </div>

            <div class="sm:col-span-2 mt-2 flex gap-2">
                <button class="rounded bg-blue-600 text-white px-4 py-2 hover:bg-blue-700">Simpan</button>
                <a href="{{ route('class-subjects.index', ['semester_id' => $semesterId, 'class_id' => $classId]) }}"
                    class="px-4 py-2 rounded border">Batal</a>
            </div>
        </form>
    </div>
@endsection
