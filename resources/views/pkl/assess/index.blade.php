@extends('layouts.app')
@section('title', 'Nilai PKL')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold">Nilai PKL — {{ $group->tempat_pkl }} • {{ $group->class->nama_kelas }}</h2>
            <a href="{{ route('pkl.members', $group) }}" class="text-blue-600 text-sm hover:underline">← Anggota</a>
        </div>

        @if (session('ok'))
            <div class="mb-3 rounded border border-emerald-200 bg-emerald-50 text-emerald-800 px-3 py-2 text-sm">
                {{ session('ok') }}</div>
        @endif

        <form method="POST" action="{{ route('pkl.assess.store', $group) }}">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-slate-500">
                        <tr>
                            <th>Nama Siswa</th>
                            <th style="width:160px">Predikat</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $s)
                            @php $r = $map[$s->id] ?? null; @endphp
                            <tr class="border-t">
                                <td class="py-2">{{ $s->nama }}</td>
                                <td class="py-2">
                                    <select name="grade[{{ $s->id }}]" class="border rounded px-2 py-1">
                                        @foreach ($grades as $g)
                                            <option value="{{ $g }}" @selected(($r->grade ?? '') == $g)>
                                                {{ $g }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="py-2">
                                    <input name="desc[{{ $s->id }}]" value="{{ $r->description ?? '' }}"
                                        class="w-full border rounded px-2 py-1">
                                </td>
                            </tr>
                            <input type="hidden" name="ids[]" value="{{ $s->id }}">
                        @empty
                            <tr>
                                <td colspan="3" class="py-3 text-slate-500">Belum ada anggota kelompok.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan Nilai</button>
            </div>
        </form>
    </div>
@endsection
