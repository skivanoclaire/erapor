@extends('layouts.app')
@section('title', 'Edit TTD Wali')

@section('content')
    <form method="POST" action="{{ route('rws.update', $row) }}" class="bg-white rounded-lg shadow p-4 max-w-3xl">
        @csrf @method('PUT')
        <h2 class="font-semibold mb-4">Edit TTD Wali per Kelas</h2>

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

        <div class="grid sm:grid-cols-2 gap-4">
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
            <label class="text-sm">Wali Kelas
                <select name="wali_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($wali as $id => $n)
                        <option value="{{ $id }}" @selected(old('wali_id', $row->wali_id) == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm">TTD (Media)
                <select name="signature_media_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($media as $m)
                        <option value="{{ $m->id }}" @selected(old('signature_media_id', $row->signature_media_id) == $m->id)>{{ $m->filename() }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div class="mt-4">
            <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan</button>
            <a href="{{ route('rws.index') }}" class="px-4 py-2 border rounded">Batal</a>
        </div>
    </form>
@endsection
