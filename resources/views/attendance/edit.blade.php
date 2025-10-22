@extends('layouts.app')
@section('title', 'Absensi Kelas')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <h2 class="font-semibold mb-2">Absensi — {{ $class->nama_kelas }} / {{ $semester->tahun_ajaran }}
            ({{ $semester->semester }})</h2>

        @if (session('ok'))
            <div class="mb-3 rounded border border-emerald-200 bg-emerald-50 text-emerald-800 px-3 py-2 text-sm">
                {{ session('ok') }}</div>
        @endif

        <form method="POST" action="{{ route('attendance.update', [$class, $semester]) }}">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-slate-500">
                        <tr>
                            <th>Nama Siswa</th>
                            <th style="width:110px">Sakit</th>
                            <th style="width:110px">Izin</th>
                            <th style="width:110px">Alpa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $s)
                            @php $r = $map[$s->id] ?? null; @endphp
                            <tr class="border-t">
                                <td class="py-2">{{ $s->nama }}</td>
                                <td class="py-2"><input type="number" min="0" name="sakit[{{ $s->id }}]"
                                        value="{{ $r->sakit ?? 0 }}" class="w-24 border rounded px-2 py-1"></td>
                                <td class="py-2"><input type="number" min="0" name="izin[{{ $s->id }}]"
                                        value="{{ $r->izin ?? 0 }}" class="w-24 border rounded px-2 py-1"></td>
                                <td class="py-2"><input type="number" min="0" name="alpa[{{ $s->id }}]"
                                        value="{{ $r->alpa ?? 0 }}" class="w-24 border rounded px-2 py-1"></td>
                            </tr>
                            <input type="hidden" name="ids[]" value="{{ $s->id }}">
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan Absensi</button>
            </div>
        </form>
    </div>
@endsection
