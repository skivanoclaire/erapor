@extends('layouts.app')
@section('title', 'Edit Tanggal Rapor')

@section('content')
    <form method="POST" action="{{ route('rdate.update', $row) }}" class="bg-white rounded-lg shadow p-4 max-w-3xl">
        @csrf @method('PUT')
        <h2 class="font-semibold mb-4">Edit Tanggal Rapor</h2>

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
            <label class="text-sm">Tanggal Rapor Tengah
                <input type="date" name="mid_report_date"
                    value="{{ old('mid_report_date', optional($row->mid_report_date)->format('Y-m-d')) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Tanggal Rapor Akhir
                <input type="date" name="final_report_date"
                    value="{{ old('final_report_date', optional($row->final_report_date)->format('Y-m-d')) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
        </div>

        <div class="mt-4">
            <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan</button>
            <a href="{{ route('rdate.index') }}" class="px-4 py-2 border rounded">Batal</a>
        </div>
    </form>
@endsection
