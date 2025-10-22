@extends('layouts.app')
@section('title', 'Penilaian')
@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="font-semibold">Penilaian — {{ $cs->class->nama_kelas }} / {{ $cs->subject->short_name }}</h2>
                <div class="text-xs text-slate-500 mb-3">
                    Rencana: F={{ $plan->planned_formatif }}, S={{ $plan->planned_sumatif }},
                    PAS={{ $plan->planned_sumatif_as }}
                    • <a href="{{ route('assessment-plans.edit', $cs) }}" class="text-blue-600 hover:underline">ubah</a>
                </div>
            </div>
            <form method="POST" action="{{ route('assessments.compute-final', $cs) }}">
                @csrf
                <button class="px-3 py-2 rounded bg-emerald-600 text-white text-sm">Hitung Nilai Akhir</button>
            </form>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold mb-2">Tambah Penilaian</h3>
                <form method="POST" action="{{ route('assessments.store', $cs) }}" class="grid sm:grid-cols-2 gap-3">
                    @csrf
                    <label class="text-sm">Judul
                        <input name="title" class="mt-1 w-full border rounded px-3 py-2" placeholder="Kuis 1 / PTS / PAS">
                    </label>
                    <label class="text-sm">Tanggal
                        <input type="date" name="date" class="mt-1 w-full border rounded px-3 py-2">
                    </label>
                    <label class="text-sm">Jenis
                        <select name="type" class="mt-1 w-full border rounded px-3 py-2">
                            <option value="formatif">Formatif</option>
                            <option value="sumatif">Sumatif</option>
                            <option value="sumatif_as">Sumatif Akhir</option>
                        </select>
                    </label>
                    <label class="text-sm">Teknik
                        <select name="technique_id" class="mt-1 w-full border rounded px-3 py-2">
                            <option value="">-</option>
                            @foreach ($techs as $t)
                                <option value="{{ $t->id }}">{{ $t->short_name }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="text-sm">Max Score
                        <input type="number" step="0.01" name="max_score" value="100"
                            class="mt-1 w-full border rounded px-3 py-2">
                    </label>
                    <label class="text-sm">Bobot
                        <input type="number" step="0.01" name="weight" value="1.00"
                            class="mt-1 w-full border rounded px-3 py-2">
                    </label>
                    <div class="sm:col-span-2">
                        <button class="rounded bg-blue-600 text-white px-4 py-2">Tambah</button>
                    </div>
                </form>
            </div>

            <div>
                <h3 class="font-semibold mb-2">Daftar</h3>
                <table class="min-w-full text-sm">
                    <thead class="text-left text-slate-500">
                        <tr>
                            <th>Tanggal</th>
                            <th>Judul</th>
                            <th>Jenis</th>
                            <th>Teknik</th>
                            <th>Bobot</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $r)
                            <tr class="border-t">
                                <td class="py-2">{{ $r->date?->format('Y-m-d') ?? '-' }}</td>
                                <td class="py-2">{{ $r->title }}</td>
                                <td class="py-2">{{ $r->type }}</td>
                                <td class="py-2">{{ $r->technique?->short_name ?? '-' }}</td>
                                <td class="py-2">{{ $r->weight }}</td>
                                <td class="py-2 text-right">
                                    <a href="{{ route('scores.edit', $r) }}"
                                        class="px-2 py-1 border rounded hover:bg-slate-50">Nilai</a>
                                    <a href="{{ route('assessments.edit', $r) }}"
                                        class="px-2 py-1 border rounded hover:bg-slate-50">Edit</a>
                                    <form method="POST" action="{{ route('assessments.destroy', $r) }}" class="inline"
                                        onsubmit="return confirm('Hapus penilaian?')">
                                        @csrf @method('DELETE')
                                        <button class="px-2 py-1 rounded bg-rose-600 text-white">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
