@extends('layouts.app')
@section('title', 'P5BK')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold">Projek P5BK</h2>
            <a href="{{ route('p5-projects.create') }}" class="px-3 py-2 rounded bg-blue-600 text-white text-sm">Tambah</a>
        </div>

        <form method="GET" class="mb-3 flex gap-2">
            <select name="semester_id" class="border rounded px-3 py-2">
                <option value="">Semua Semester</option>
                @foreach ($semesters as $id => $label)
                    <option value="{{ $id }}" @selected(($semesterId ?? '') == $id)>{{ $label }}</option>
                @endforeach
            </select>
            <select name="class_id" class="border rounded px-3 py-2">
                <option value="">Semua Kelas</option>
                @foreach ($classes as $id => $label)
                    <option value="{{ $id }}" @selected(($classId ?? '') == $id)>{{ $label }}</option>
                @endforeach
            </select>
            <button class="px-3 py-2 border rounded">Filter</button>
        </form>

        <table class="min-w-full text-sm">
            <thead class="text-left text-slate-500">
                <tr>
                    <th>Kelas</th>
                    <th>Semester</th>
                    <th>Tema</th>
                    <th>Mentor</th>
                    <th>Sub-elemen</th>
                    <th>Aktif</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $r)
                    <tr class="border-t">
                        <td class="py-2">{{ $r->class->nama_kelas ?? '-' }}</td>
                        <td class="py-2">{{ $r->semester->tahun_ajaran ?? '' }} ({{ $r->semester->semester ?? '' }})</td>
                        <td class="py-2">{{ $r->theme }}</td>
                        <td class="py-2">{{ $r->mentor->nama ?? '-' }}</td>
                        <td class="py-2">
                            {{ $r->criteria_count }}{{ $r->subelement_count ? '/' . $r->subelement_count : '' }}
                        </td>

                        <td class="py-2">
                            <form method="POST" action="{{ route('p5.toggle', $r) }}">@csrf @method('PATCH')
                                <button
                                    class="px-2 py-1 rounded {{ $r->active ? 'bg-emerald-600' : 'bg-slate-400' }} text-white">{{ $r->active ? 'ON' : 'OFF' }}</button>
                            </form>
                        </td>
                        <td class="py-2 text-right">
                            <a href="{{ route('p5.members', $r) }}"
                                class="px-2 py-1 border rounded hover:bg-slate-50">Anggota</a>
                            <a href="{{ route('p5.criteria', $r) }}"
                                class="px-2 py-1 border rounded hover:bg-slate-50">Kriteria</a>
                            <a href="{{ route('p5.ratings.index', $r) }}"
                                class="px-2 py-1 border rounded hover:bg-slate-50">Nilai</a>
                            <a href="{{ route('p5-projects.edit', $r) }}"
                                class="px-2 py-1 border rounded hover:bg-slate-50">Edit</a>
                            <form method="POST" action="{{ route('p5-projects.destroy', $r) }}" class="inline"
                                onsubmit="return confirm('Hapus projek?')">
                                @csrf @method('DELETE') <button
                                    class="px-2 py-1 rounded bg-rose-600 text-white">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">{{ $rows->links() }}</div>
    </div>
@endsection
