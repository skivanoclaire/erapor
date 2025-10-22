@extends('layouts.app')
@section('title', 'Mapel Kelas')
@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold">Mapel Kelas</h2>
            <a href="{{ route('class-subjects.create', ['semester_id' => $semesterId, 'class_id' => $classId]) }}"
                class="px-3 py-2 rounded bg-blue-600 text-white text-sm">Tambah</a>
        </div>

        <form method="GET" class="mb-3 flex gap-2">
            <select name="semester_id" class="border rounded px-3 py-2">
                <option value="">Semua Semester</option>
                @foreach ($semesters as $id => $label)
                    <option value="{{ $id }}" @selected($semesterId == $id)>{{ $label }}</option>
                @endforeach
            </select>
            <select name="class_id" class="border rounded px-3 py-2">
                <option value="">Semua Kelas</option>
                @foreach ($classes as $id => $label)
                    <option value="{{ $id }}" @selected($classId == $id)>{{ $label }}</option>
                @endforeach
            </select>
            <button class="px-3 py-2 border rounded">Filter</button>
        </form>

        <table class="min-w-full text-sm">
            <thead class="text-left text-slate-500">
                <tr>
                    <th>Kelas</th>
                    <th>Semester</th>
                    <th>Mapel</th>
                    <th>Urut</th>
                    <th>Guru</th>
                    <th>Aktif</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $r)
                    <tr class="border-t">
                        <td class="py-2">{{ $r->class->nama_kelas ?? '-' }}</td>
                        <td class="py-2">{{ $r->semester->tahun_ajaran ?? '' }} ({{ $r->semester->semester ?? '' }})</td>
                        <td class="py-2">{{ $r->subject->short_name ?? '' }}</td>
                        <td class="py-2">{{ $r->order_no }}</td>
                        <td class="py-2">{{ $r->teacher->nama ?? '-' }}</td>
                        <td class="py-2">
                            <form method="POST" action="{{ route('class-subjects.toggle', $r) }}">
                                @csrf @method('PATCH')
                                <button
                                    class="px-2 py-1 rounded {{ $r->active ? 'bg-emerald-600' : 'bg-slate-400' }} text-white">
                                    {{ $r->active ? 'ON' : 'OFF' }}
                                </button>
                            </form>
                        </td>
                        <td class="py-2 text-right">
                            <a href="{{ route('assessments.board', $r) }}" class="px-2 py-1 border rounded">Penilaian
                                Formatif - Sumatif
                            </a>

                            <a href="{{ route('class-subjects.enrollments', $r) }}"
                                class="px-2 py-1 border rounded hover:bg-slate-50">Enroll</a>
                            <a href="{{ route('class-subjects.edit', $r) }}"
                                class="px-2 py-1 border rounded hover:bg-slate-50">Edit</a>
                            <form method="POST" action="{{ route('class-subjects.destroy', $r) }}" class="inline"
                                onsubmit="return confirm('Hapus mapel kelas?')">
                                @csrf @method('DELETE')
                                <button class="px-2 py-1 rounded bg-rose-600 text-white">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">{{ $rows->links() }}</div>
    </div>
@endsection
