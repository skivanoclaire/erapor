@extends('layouts.app')
@section('title', 'Enroll Siswa ke Mapel')
@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-semibold">Enroll: {{ $cs->subject->short_name }} — {{ $cs->class->nama_kelas }}</h2>
                <div class="text-xs text-slate-500">Semester: {{ $cs->semester->tahun_ajaran }}
                    ({{ $cs->semester->semester }})</div>
            </div>
            <form method="POST" action="{{ route('class-subjects.enroll-all', $cs) }}">
                @csrf
                <button class="px-3 py-2 rounded bg-emerald-600 text-white text-sm">Enroll semua siswa kelas</button>
            </form>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold mb-2">Sudah Terdaftar</h3>
                <ul class="space-y-2">
                    @forelse($enrolled as $s)
                        <li class="flex items-center justify-between border rounded px-3 py-2">
                            <span>{{ $s->nama }}</span>
                            <form method="POST" action="{{ route('class-subjects.enrollments.destroy', [$cs, $s->id]) }}">
                                @csrf @method('DELETE')
                                <button class="text-rose-600 text-sm">Hapus</button>
                            </form>
                        </li>
                    @empty
                        <li class="text-sm text-slate-500">Belum ada.</li>
                    @endforelse
                </ul>
            </div>

            <div>
                <h3 class="font-semibold mb-2">Belum Terdaftar</h3>
                <ul class="space-y-2">
                    @forelse($notYet as $s)
                        <li class="flex items-center justify-between border rounded px-3 py-2">
                            <span>{{ $s->nama }}</span>
                            <form method="POST" action="{{ route('class-subjects.enrollments.store', $cs) }}">
                                @csrf
                                <input type="hidden" name="student_id" value="{{ $s->id }}">
                                <button class="text-blue-600 text-sm">Tambah</button>
                            </form>
                        </li>
                    @empty
                        <li class="text-sm text-slate-500">Semua siswa sudah terdaftar.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
