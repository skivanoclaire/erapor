@extends('layouts.app')
@section('title', 'Edit Kelompok PKL')

@section('content')
    <form method="POST" action="{{ route('pkl-groups.update', $row) }}" class="bg-white rounded-lg shadow p-4 max-w-4xl">
        @csrf
        @method('PUT')

        <div class="flex items-start justify-between mb-3">
            <div>
                <h2 class="font-semibold">Edit Kelompok PKL</h2>
                <div class="text-xs text-slate-500">
                    {{ $row->tempat_pkl }} • SK: {{ $row->sk_penugasan }}
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('pkl.members', $row) }}"
                    class="px-3 py-2 border rounded hover:bg-slate-50 text-sm">Anggota</a>
                <a href="{{ route('pkl.assess.index', $row) }}"
                    class="px-3 py-2 border rounded hover:bg-slate-50 text-sm">Nilai</a>
            </div>
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

        <div class="grid sm:grid-cols-2 gap-4">
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

            <label class="text-sm">Kelas
                <select name="class_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($classes as $id => $n)
                        <option value="{{ $id }}" @selected(old('class_id', $row->class_id) == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>

            <label class="text-sm">Guru Pembimbing
                <select name="pembimbing_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($mentors as $id => $n)
                        <option value="{{ $id }}" @selected(old('pembimbing_id', $row->pembimbing_id) == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>

            <label class="text-sm sm:col-span-2">Tujuan Pembelajaran (opsional)
                <select name="learning_objective_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($objectives as $id => $n)
                        <option value="{{ $id }}" @selected(old('learning_objective_id', $row->learning_objective_id) == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div class="grid sm:grid-cols-2 gap-4 mt-3">
            <label class="text-sm">Nomor SK Penugasan
                <input name="sk_penugasan" value="{{ old('sk_penugasan', $row->sk_penugasan) }}"
                    class="mt-1 w-full border rounded px-3 py-2" maxlength="100">
            </label>

            <label class="text-sm">Tempat PKL
                <input name="tempat_pkl" value="{{ old('tempat_pkl', $row->tempat_pkl) }}"
                    class="mt-1 w-full border rounded px-3 py-2" maxlength="200">
            </label>

            <label class="text-sm">Mulai
                <input type="date" name="started_at"
                    value="{{ old('started_at', optional($row->started_at)->format('Y-m-d')) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>

            <label class="text-sm">Selesai
                <input type="date" name="ended_at"
                    value="{{ old('ended_at', optional($row->ended_at)->format('Y-m-d')) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
        </div>

        <div class="mt-4 flex gap-2">
            <button class="rounded bg-blue-600 text-white px-4 py-2 hover:bg-blue-700">Simpan</button>
            <a href="{{ route('pkl-groups.index') }}" class="px-4 py-2 border rounded">Batal</a>
        </div>
    </form>
@endsection
