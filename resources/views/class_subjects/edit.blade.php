@extends('layouts.app')
@section('title', 'Edit Mapel Kelas')

@section('content')
    <form method="POST" action="{{ route('class-subjects.update', $cs) }}" class="bg-white rounded-lg shadow p-4 max-w-3xl">
        @csrf
        @method('PUT')

        <h2 class="font-semibold mb-1">Edit Mapel Kelas</h2>
        <div class="text-xs text-slate-500 mb-4">
            {{ $cs->class->nama_kelas ?? '-' }} — {{ $cs->subject->short_name ?? '-' }}
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            {{-- Sekolah --}}
            <label class="text-sm">Sekolah
                <select name="school_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($schools as $id => $n)
                        <option value="{{ $id }}" @selected($cs->school_id == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>

            {{-- Semester --}}
            <label class="text-sm">Semester
                <select name="semester_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($semesters as $id => $label)
                        <option value="{{ $id }}" @selected($cs->semester_id == $id)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>

            {{-- Kelas --}}
            <label class="text-sm">Kelas
                <select name="class_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($classes as $id => $n)
                        <option value="{{ $id }}" @selected($cs->class_id == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>

            {{-- Mapel --}}
            <label class="text-sm">Mapel
                <select name="subject_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($subjects as $id => $n)
                        <option value="{{ $id }}" @selected($cs->subject_id == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>

            {{-- Guru Pengampu --}}
            <label class="text-sm">Guru Pengampu
                <select name="teacher_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($teachers as $id => $n)
                        <option value="{{ $id }}" @selected($cs->teacher_id == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>

            {{-- Urutan Tampil --}}
            <label class="text-sm">Urutan Tampil
                <input name="order_no" type="number" min="1" value="{{ old('order_no', $cs->order_no) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>

            {{-- Gabung Dengan (opsional) --}}
            <label class="text-sm sm:col-span-2">Gabung Dengan (opsional)
                <select name="combined_with_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($candidates as $id => $label)
                        @continue($id == $cs->id) {{-- hindari memilih dirinya sendiri --}}
                        <option value="{{ $id }}" @selected($cs->combined_with_id == $id)>{{ $label }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-500 mt-1">Jika diisi, nilai mapel ini dianggap gabung dengan ID yang dipilih
                    (untuk rekap tertentu).</p>
            </label>

            {{-- Kelompok Override (opsional) --}}
            <label class="text-sm sm:col-span-2">Kelompok Override (opsional)
                <input name="group" value="{{ old('group', $cs->group) }}" class="mt-1 w-full border rounded px-3 py-2"
                    placeholder="Mis. Kelompok A / B">
            </label>

            {{-- Aktif? --}}
            <label class="text-sm inline-flex items-center gap-2 sm:col-span-2 mt-2">
                <input type="checkbox" name="active" value="1" @checked($cs->active)> Aktif?
            </label>
        </div>

        <div class="mt-4 flex gap-2">
            <button class="rounded bg-blue-600 text-white px-4 py-2 hover:bg-blue-700">Simpan Perubahan</button>
            <a href="{{ route('class-subjects.index', ['semester_id' => $cs->semester_id, 'class_id' => $cs->class_id]) }}"
                class="px-4 py-2 rounded border">Batal</a>
        </div>
    </form>
@endsection
