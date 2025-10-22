@extends('layouts.app')
@section('title', 'Nilai Ekskul')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold">{{ $ex->name }} — Penilaian</h2>
            <form method="GET">
                <select name="semester_id" class="border rounded px-3 py-2" onchange="this.form.submit()">
                    @foreach ($semesters as $id => $label)
                        <option value="{{ $id }}" @selected($semesterId == $id)>{{ $label }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        @if (session('ok'))
            <div class="mb-3 rounded border border-emerald-200 bg-emerald-50 text-emerald-800 px-3 py-2 text-sm">
                {{ session('ok') }}</div>
        @endif

        <form method="POST" action="{{ route('ex.assess.store', $ex) }}">
            @csrf
            <input type="hidden" name="semester_id" value="{{ $semesterId }}">

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-slate-500">
                        <tr>
                            <th>Nama Siswa</th>
                            <th style="width:140px">Tengah</th>
                            <th>Deskripsi Tengah</th>
                            <th style="width:140px">Akhir</th>
                            <th>Deskripsi Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $s)
                            @php $r = $map[$s->id] ?? null; @endphp
                            <tr class="border-t">
                                <td class="py-2">{{ $s->nama }}</td>
                                <td class="py-2">
                                    <select name="mid_grade[{{ $s->id }}]" class="border rounded px-2 py-1">
                                        @foreach ($grades as $g)
                                            <option value="{{ $g }}" @selected(($r->mid_grade ?? '') == $g)>
                                                {{ $g }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="py-2"><input name="mid_desc[{{ $s->id }}]"
                                        value="{{ $r->mid_description ?? '' }}" class="w-full border rounded px-2 py-1">
                                </td>
                                <td class="py-2">
                                    <select name="final_grade[{{ $s->id }}]" class="border rounded px-2 py-1">
                                        @foreach ($grades as $g)
                                            <option value="{{ $g }}" @selected(($r->final_grade ?? '') == $g)>
                                                {{ $g }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="py-2"><input name="final_desc[{{ $s->id }}]"
                                        value="{{ $r->final_description ?? '' }}" class="w-full border rounded px-2 py-1">
                                </td>
                            </tr>
                            <input type="hidden" name="ids[]" value="{{ $s->id }}">
                        @empty
                            <tr>
                                <td colspan="5" class="py-3 text-slate-500">Belum ada anggota pada semester ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan Penilaian</button>
            </div>
        </form>
    </div>
@endsection
