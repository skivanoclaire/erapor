@extends('layouts.app')
@section('title', 'Input Nilai Akhir — ' . $cs->subject->name)

@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="mb-3">
            <div class="text-sm text-slate-600">
                Kelas: <b>{{ $cs->class->nama_kelas ?? '-' }}</b> •
                Semester: <b>{{ $cs->semester->tahun_ajaran ?? '' }}
                    {{ $cs->semester ? '(' . $cs->semester->semester . ')' : '' }}</b> •
                Mapel: <b>{{ $cs->subject->name ?? '-' }}</b> •
                Guru: <b>{{ $cs->teacher->nama ?? '-' }}</b>
            </div>
        </div>

        @if (session('ok'))
            <div class="mb-3 rounded border border-emerald-200 bg-emerald-50 text-emerald-800 px-3 py-2 text-sm">
                {{ session('ok') }}</div>
        @endif
        @if (session('err'))
            <div class="mb-3 rounded border border-rose-200 bg-rose-50 text-rose-800 px-3 py-2 text-sm">{{ session('err') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-3 rounded border border-rose-200 bg-rose-50 text-rose-800 px-3 py-2 text-sm">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex items-center gap-2 mb-3">
            <a href="{{ route('class-subjects.index') }}" class="px-3 py-2 border rounded text-sm">← Mapel Kelas</a>

            <form method="POST" action="{{ route('class-subjects.final-grades.recompute', $cs) }}"
                onsubmit="return confirm('Hitung otomatis dari penilaian? Nilai yang sudah ada akan ditimpa untuk siswa yang memiliki skor penilaian.')">
                @csrf
                <button class="px-3 py-2 rounded bg-amber-600 text-white text-sm">Hitung dari Penilaian</button>
            </form>
        </div>

        <form method="POST" action="{{ route('class-subjects.final-grades.update', $cs) }}">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-slate-500">
                        <tr>
                            <th class="w-10">No</th>
                            <th>Nama Siswa</th>
                            <th class="w-32">Nilai Akhir</th>
                            <th>Capaian Kompetensi (Deskripsi)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $i=>$s)
                            @php
                                $existing_grade = $existing->get($s->id);
                                $val = optional($existing_grade)->final_score;
                                $desc = optional($existing_grade)->description;
                            @endphp
                            <tr class="border-t">
                                <td class="py-2">{{ $i + 1 }}</td>
                                <td class="py-2">{{ $s->nama }}</td>
                                <td class="py-2">
                                    <input type="number" step="0.01" min="0" max="1000"
                                        name="scores[{{ $s->id }}]" value="{{ old('scores.' . $s->id, $val) }}"
                                        class="w-28 border rounded px-2 py-1 text-right">
                                </td>
                                <td class="py-2">
                                    <textarea
                                        name="descriptions[{{ $s->id }}]"
                                        rows="2"
                                        class="w-full border rounded px-2 py-1 text-sm"
                                        placeholder="Contoh: Menunjukkan penguasaan yang sangat baik dalam..."
                                    >{{ old('descriptions.' . $s->id, $desc) }}</textarea>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-slate-500">Belum ada siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <button class="px-4 py-2 rounded bg-blue-600 text-white">Simpan</button>
                <a href="{{ route('legger.index', ['semester_id' => $cs->semester_id, 'class_id' => $cs->class_id]) }}"
                    class="px-4 py-2 border rounded">Lihat Legger</a>
            </div>
        </form>
    </div>
@endsection
