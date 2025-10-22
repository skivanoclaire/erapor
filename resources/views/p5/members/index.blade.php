@extends('layouts.app')
@section('title', 'Anggota Projek')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-3">
            <div>
                <h2 class="font-semibold">Anggota — {{ $p5->class->nama_kelas }} / {{ $p5->theme }}</h2>
                <div class="text-xs text-slate-500">Semester: {{ $p5->semester->tahun_ajaran }}
                    ({{ $p5->semester->semester }})</div>
            </div>
            <form method="POST" action="{{ route('p5.members.enroll-all', $p5) }}"> @csrf
                <button class="px-3 py-2 rounded bg-emerald-600 text-white text-sm">Tambah semua siswa kelas</button>
            </form>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold mb-2">Sudah Terdaftar ({{ count($enrolled) }})</h3>
                <ul class="space-y-2">
                    @foreach ($enrolled as $s)
                        <li class="flex items-center justify-between border rounded px-3 py-2">
                            <span>{{ $s->nama }}</span>
                            <form method="POST" action="{{ route('p5.members.destroy', [$p5, $s->id]) }}"> @csrf
                                @method('DELETE')
                                <button class="text-rose-600 text-sm">Hapus</button>
                            </form>
                        </li>
                    @endforeach
                    @if (!count($enrolled))
                        <li class="text-sm text-slate-500">Belum ada.</li>
                    @endif
                </ul>
            </div>
            <div>
                <h3 class="font-semibold mb-2">Belum Terdaftar ({{ count($notYet) }})</h3>
                <ul class="space-y-2">
                    @foreach ($notYet as $s)
                        <li class="flex items-center justify-between border rounded px-3 py-2">
                            <span>{{ $s->nama }}</span>
                            <form method="POST" action="{{ route('p5.members.store', $p5) }}"> @csrf
                                <input type="hidden" name="student_id" value="{{ $s->id }}">
                                <button class="text-blue-600 text-sm">Tambah</button>
                            </form>
                        </li>
                    @endforeach
                    @if (!count($notYet))
                        <li class="text-sm text-slate-500">Semua siswa sudah terdaftar.</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection
