@extends('layouts.app')
@section('title', 'Kenaikan Kelas')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <h2 class="font-semibold mb-2">Keputusan Kenaikan — {{ $class->nama_kelas }} / {{ $semester->tahun_ajaran }}
            ({{ $semester->semester }})</h2>

        @if (session('ok'))
            <div class="mb-3 rounded border border-emerald-200 bg-emerald-50 text-emerald-800 px-3 py-2 text-sm">
                {{ session('ok') }}</div>
        @endif

        <form method="POST" action="{{ route('promotions.store', [$class, $semester]) }}">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-slate-500">
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Keputusan</th>
                            <th>Kelas Tujuan</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $s)
                            @php $r = $map[$s->id] ?? null; @endphp
                            <tr class="border-t">
                                <td class="py-2">{{ $s->nama }}</td>
                                <td class="py-2">
                                    <label class="inline-flex items-center gap-1 mr-3">
                                        <input type="radio" name="promoted[{{ $s->id }}]" value="1"
                                            {{ $r?->promoted ?? true ? 'checked' : '' }}> Naik
                                    </label>
                                    <label class="inline-flex items-center gap-1">
                                        <input type="radio" name="promoted[{{ $s->id }}]" value="0"
                                            {{ $r && !$r->promoted ? 'checked' : '' }}> Tidak
                                    </label>
                                </td>
                                <td class="py-2">
                                    <select name="next[{{ $s->id }}]" class="border rounded px-2 py-1">
                                        <option value="">-</option>
                                        @foreach ($nextClasses as $id => $n)
                                            <option value="{{ $id }}" @selected($r?->next_class_id == $id)>
                                                {{ $n }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="py-2">
                                    <input name="note[{{ $s->id }}]" value="{{ $r?->note }}"
                                        class="w-64 border rounded px-2 py-1">
                                </td>
                            </tr>
                            <input type="hidden" name="ids[]" value="{{ $s->id }}">
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan Keputusan</button>
            </div>
        </form>
    </div>
@endsection
