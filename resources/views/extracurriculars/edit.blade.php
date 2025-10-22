@extends('layouts.app')
@section('title', 'Edit Ekstrakurikuler')

@section('content')
    <form method="POST" action="{{ route('extracurriculars.update', $row) }}"
        class="bg-white rounded-lg shadow p-4 max-w-3xl">
        @csrf
        @method('PUT')

        <div class="flex items-start justify-between mb-3">
            <div>
                <h2 class="font-semibold">Edit Ekstrakurikuler</h2>
                <div class="text-xs text-slate-500">{{ $row->name }}</div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('ex.members', $row) }}"
                    class="px-3 py-2 border rounded hover:bg-slate-50 text-sm">Anggota</a>
                <a href="{{ route('ex.assess.index', $row) }}"
                    class="px-3 py-2 border rounded hover:bg-slate-50 text-sm">Nilai</a>
            </div>
        </div>

        {{-- Flash & error --}}
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

        <div class="space-y-4">
            <label class="block text-sm">Sekolah
                <select name="school_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($schools as $id => $n)
                        <option value="{{ $id }}" @selected(old('school_id', $row->school_id) == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>

            <label class="block text-sm">Nama
                <input name="name" value="{{ old('name', $row->name) }}" class="mt-1 w-full border rounded px-3 py-2">
            </label>

            <label class="block text-sm">Mentor
                <select name="mentor_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($mentors as $id => $n)
                        <option value="{{ $id }}" @selected(old('mentor_id', $row->mentor_id) == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>

            <label class="text-sm inline-flex items-center gap-2">
                <input type="checkbox" name="active" value="1" @checked(old('active', $row->active))> Aktif?
            </label>
        </div>

        <div class="mt-4 flex gap-2">
            <button class="rounded bg-blue-600 text-white px-4 py-2 hover:bg-blue-700">Simpan</button>
            <a href="{{ route('extracurriculars.index') }}" class="px-4 py-2 rounded border">Batal</a>
        </div>
    </form>
@endsection
