@extends('layouts.app')
@section('title', 'Pengaturan Rapor')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold">Pengaturan Rapor</h2>
            <a href="{{ route('report-settings.create') }}"
                class="px-3 py-2 rounded bg-blue-600 text-white text-sm">Tambah</a>
        </div>

        <form method="GET" class="mb-3 flex gap-2">
            <select name="school_id" class="border rounded px-3 py-2">
                <option value="">Semua Sekolah</option>
                @foreach ($schools as $id => $n)
                    <option value="{{ $id }}" @selected(($schoolId ?? '') == $id)>{{ $n }}</option>
                @endforeach
            </select>
            <select name="semester_id" class="border rounded px-3 py-2">
                <option value="">Semua Semester</option>
                @foreach ($semesters as $id => $n)
                    <option value="{{ $id }}" @selected(($semesterId ?? '') == $id)>{{ $n }}</option>
                @endforeach
            </select>
            <button class="px-3 py-2 border rounded">Filter</button>
        </form>

        <table class="min-w-full text-sm">
            <thead class="text-left text-slate-500">
                <tr>
                    <th>Sekolah</th>
                    <th>Semester</th>
                    <th>Kertas</th>
                    <th>Judul</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $r)
                    <tr class="border-top">
                        <td class="py-2">{{ $r->school->nama_sekolah ?? '-' }}</td>
                        <td class="py-2">{{ $r->semester->tahun_ajaran ?? '' }}
                            {{ $r->semester ? '(' . $r->semester->semester . ')' : '' }}</td>
                        <td class="py-2">{{ $r->jenis_kertas }}</td>
                        <td class="py-2">{{ $r->judul_rapor }}</td>
                        <td class="py-2 text-right">
                            <a href="{{ route('report-settings.edit', $r) }}" class="px-2 py-1 border rounded">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">{{ $rows->links() }}</div>
    </div>
@endsection
