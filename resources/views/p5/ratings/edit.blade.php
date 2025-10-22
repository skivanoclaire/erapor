@extends('layouts.app')
@section('title', 'Nilai P5BK')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-3">
            <div>
                <h2 class="font-semibold">Nilai — {{ $student->nama }}</h2>
                <div class="text-xs text-slate-500">{{ $p5->theme }} • {{ $p5->class->nama_kelas }} •
                    {{ $p5->semester->tahun_ajaran }} ({{ $p5->semester->semester }})</div>
            </div>
            <a href="{{ route('p5.ratings.index', $p5) }}" class="text-blue-600 text-sm hover:underline">← Kembali</a>
        </div>

        <form method="POST" action="{{ route('p5.ratings.update', [$p5, $student->id]) }}">
            @csrf
            <table class="min-w-full text-sm">
                <thead class="text-left text-slate-500">
                    <tr>
                        <th style="width:60px">Urut</th>
                        <th>Kriteria/Sub-elemen</th>
                        <th style="width:140px">Level</th>
                        <th>Deskripsi (opsional)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($criteria as $c)
                        @php $r = $map[$c->id] ?? null; @endphp
                        <tr class="border-t">
                            <td class="py-2">{{ $c->order_no }}</td>
                            <td class="py-2">{{ $c->title ?? '-' }}</td>
                            <td class="py-2">
                                <select name="level[{{ $c->id }}]" class="border rounded px-2 py-1">
                                    @foreach ($levels as $k => $v)
                                        <option value="{{ $k }}" @selected(($r->level ?? '') == $k)>
                                            {{ $v }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="py-2">
                                <input name="desc[{{ $c->id }}]" class="w-full border rounded px-2 py-1"
                                    value="{{ $r->description ?? '' }}">
                            </td>
                        </tr>
                    @endforeach
                    @if (!$criteria->count())
                        <tr>
                            <td colspan="4" class="py-3 text-slate-500">Belum ada kriteria. Tambahkan dulu di menu
                                Kriteria.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="mt-4">
                <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan Nilai</button>
            </div>
        </form>
    </div>
@endsection
