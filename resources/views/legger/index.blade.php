@extends('layouts.app')
@section('title', 'Daftar Legger')

@section('content')
    <div class="bg-white rounded-lg shadow p-4 overflow-x-auto">
        <h2 class="font-semibold mb-3">Daftar Legger</h2>

        <form method="GET" class="mb-3 flex flex-wrap items-end gap-2">
            <label class="text-sm">Semester
                <select name="semester_id" class="mt-1 border rounded px-3 py-2">
                    <option value="">— Pilih —</option>
                    @foreach ($semesters as $id => $n)
                        <option value="{{ $id }}" @selected(($semesterId ?? '') == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm">Kelas
                <select name="class_id" class="mt-1 border rounded px-3 py-2">
                    <option value="">— Pilih —</option>
                    @foreach ($classes as $id => $n)
                        <option value="{{ $id }}" @selected(($classId ?? '') == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>
            <button class="px-3 py-2 border rounded">Terapkan</button>
        </form>

        @if ($semesterId && $classId)
            @if ($subjects->isEmpty())
                <div class="p-3 text-slate-500">Belum ada mapel aktif untuk kelas & semester ini.</div>
            @else
                <table class="min-w-full text-sm border">
                    <thead class="text-left text-slate-600">
                        <tr>
                            <th class="px-2 py-2 w-10">No</th>
                            <th class="px-2 py-2 w-64">Nama</th>
                            @foreach ($subjects as $cs)
                                <th class="px-2 py-2 text-center">{{ $cs->subject->short_name ?? 'MPL' }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $i=>$s)
                            <tr class="border-t">
                                <td class="px-2 py-1">{{ $i + 1 }}</td>
                                <td class="px-2 py-1">{{ $s->nama }}</td>
                                @foreach ($subjects as $cs)
                                    @php $val = $matrix[$s->id][$cs->id] ?? null; @endphp
                                    <td class="px-2 py-1 text-center">{{ $val !== null ? number_format($val, 2) : '' }}</td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 2 + $subjects->count() }}" class="py-6 text-center text-slate-500">Tidak ada
                                    siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-2 text-xs text-slate-500">
                    * Header kolom memakai <em>short_name</em> mapel. Nilai diambil dari tabel <code>final_grades</code>.
                </div>
            @endif
        @else
            <div class="p-3 text-slate-500">Pilih semester & kelas lalu tekan <b>Terapkan</b>.</div>
        @endif
    </div>
@endsection
