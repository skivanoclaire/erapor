@extends('layouts.app')
@section('title', 'TTD Wali Kelas')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold">TTD Wali per Kelas</h2>
            <a href="{{ route('rws.create') }}" class="px-3 py-2 rounded bg-blue-600 text-white text-sm">Tambah</a>
        </div>

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
                    <th>Semester</th>
                    <th>Kelas</th>
                    <th>Wali</th>
                    <th>TTD</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $r)
                    <tr class="border-t">
                        <td class="py-2">{{ $r->semester->tahun_ajaran ?? '' }}
                            {{ $r->semester ? '(' . $r->semester->semester . ')' : '' }}</td>
                        <td class="py-2">{{ $r->class->nama_kelas ?? '-' }}</td>
                        <td class="py-2">{{ $r->wali->nama ?? '-' }}</td>
                        <td class="py-2">
                            @if ($r->media)
                                <a href="{{ asset('storage/' . $r->media->path) }}" class="text-blue-600 hover:underline"
                                    target="_blank">{{ $r->media->filename() }}</a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="py-2 text-right">
                            <a href="{{ route('rws.edit', $r) }}" class="px-2 py-1 border rounded">Edit</a>
                            <form method="POST" action="{{ route('rws.destroy', $r) }}" class="inline"
                                onsubmit="return confirm('Hapus TTD ini?')">
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
