@extends('layouts.app')
@section('title', 'Monitor Penilaian')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <h2 class="font-semibold mb-3">Monitor Penilaian</h2>

        <form method="GET" class="mb-3 flex gap-2">
            <select name="semester_id" class="border rounded px-3 py-2">
                <option value="">Semua Semester</option>
                @foreach ($semesters as $id => $n)
                    <option value="{{ $id }}" @selected(($semesterId ?? '') == $id)>{{ $n }}</option>
                @endforeach
            </select>
            <select name="class_id" class="border rounded px-3 py-2">
                <option value="">Semua Kelas</option>
                @foreach ($classes as $id => $n)
                    <option value="{{ $id }}" @selected(($classId ?? '') == $id)>{{ $n }}</option>
                @endforeach
            </select>
            <button class="px-3 py-2 border rounded">Filter</button>
        </form>

        <table class="min-w-full text-sm">
            <thead class="text-left text-slate-500">
                <tr>
                    <th class="w-8">No</th>
                    <th>Kelas</th>
                    <th>Semester</th>
                    <th>Mapel</th>
                    <th>Guru Mapel</th>
                    <th class="text-center">Formatif</th>
                    <th class="text-center">Sumatif</th>
                    <th class="text-center">Sumatif AS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rows as $i=>$r)
                    <tr class="border-t">
                        <td class="py-2">{{ $i + 1 }}</td>
                        <td class="py-2">{{ $r->class->nama_kelas ?? '-' }}</td>
                        <td class="py-2">{{ $r->semester->tahun_ajaran ?? '' }}
                            {{ $r->semester ? '(' . $r->semester->semester . ')' : '' }}</td>
                        <td class="py-2">{{ $r->subject->name ?? '-' }}</td>
                        <td class="py-2">{{ $r->teacher->nama ?? '-' }}</td>
                        <td class="py-2 text-center">{{ $r->formatif_count }}</td>
                        <td class="py-2 text-center">{{ $r->sumatif_count }}</td>
                        <td class="py-2 text-center">{{ $r->sumatif_as_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-6 text-center text-slate-500">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
