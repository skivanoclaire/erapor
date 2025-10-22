@extends('layouts.app')
@section('title', 'Input Nilai')
@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-semibold">Nilai — {{ $assessment->title }}</h2>
                <div class="text-xs text-slate-500">
                    {{ $cs->class->nama_kelas }} / {{ $cs->subject->short_name }} — Jenis: {{ $assessment->type }} — Bobot:
                    {{ $assessment->weight }}
                </div>
            </div>
            <a href="{{ route('assessments.index', $cs) }}" class="text-blue-600 text-sm hover:underline">Kembali</a>
        </div>

        <form method="POST" action="{{ route('scores.update', $assessment) }}">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-slate-500">
                        <tr>
                            <th>Nama Siswa</th>
                            <th style="width:160px">Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $s)
                            <tr class="border-t">
                                <td class="py-2">{{ $s->nama }}</td>
                                <td class="py-2">
                                    <input name="scores[{{ $s->id }}]"
                                        value="{{ old('scores.' . $s->id, $scores[$s->id] ?? '') }}" type="number"
                                        step="0.01" class="w-40 border rounded px-3 py-2">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan Nilai</button>
            </div>
        </form>
    </div>
@endsection
