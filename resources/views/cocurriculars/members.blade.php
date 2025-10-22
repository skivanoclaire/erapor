@extends('layouts.app')
@section('title', 'Anggota Kokurikuler')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-3">
            <div>
                <h2 class="font-semibold">{{ $co->name }} — Anggota</h2>
                <div class="text-xs text-slate-500">
                    Kelas: {{ $co->class->nama_kelas ?? '-' }} • Semester: {{ $co->semester->tahun_ajaran ?? '-' }}
                    {{ $co->semester ? '(' . $co->semester->semester . ')' : '' }}
                </div>
            </div>
            <a href="{{ route('co.assess.index', $co) }}" class="text-blue-600 text-sm hover:underline">Nilai →</a>
        </div>

        <form method="GET" class="mb-3 flex gap-2">
            <select name="class_id" class="border rounded px-3 py-2" onchange="this.form.submit()">
                @foreach ($classes as $id => $n)
                    <option value="{{ $id }}" @selected($classId == $id)>{{ $n }}</option>
                @endforeach
            </select>
        </form>

        <form method="POST" action="{{ route('co.members.enroll-class', $co) }}" class="mb-3">
            @csrf
            <input type="hidden" name="class_id" value="{{ $classId }}">
            <button class="px-3 py-2 rounded bg-emerald-600 text-white text-sm">Tambah semua siswa kelas terpilih</button>
        </form>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold mb-2">Sudah Terdaftar ({{ count($enrolled) }})</h3>
                <ul class="space-y-2">
                    @forelse($enrolled as $s)
                        <li class="flex items-center justify-between border rounded px-3 py-2">
                            <span>{{ $s->nama }}</span>
                            <form method="POST" action="{{ route('co.members.destroy', [$co, $s->id]) }}">
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
                <h3 class="font-semibold mb-2">Kandidat (kelas terpilih)</h3>
                <ul class="space-y-2">
                    @forelse($candidates as $s)
                        <li class="flex items-center justify-between border rounded px-3 py-2">
                            <span>{{ $s->nama }}</span>
                            <form method="POST" action="{{ route('co.members.store', $co) }}">
                                @csrf
                                <input type="hidden" name="student_id" value="{{ $s->id }}">
                                <button class="text-blue-600 text-sm">Tambah</button>
                            </form>
                        </li>
                    @empty
                        <li class="text-sm text-slate-500">Pilih kelas untuk melihat kandidat.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
