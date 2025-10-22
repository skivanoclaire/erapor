@extends('layouts.app')
@section('title', 'Anggota Kelompok PKL')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-3">
            <div>
                <h2 class="font-semibold">Anggota — {{ $group->tempat_pkl }} ({{ $group->class->nama_kelas }})</h2>
                <div class="text-xs text-slate-500">SK: {{ $group->sk_penugasan }}</div>
            </div>
            <a href="{{ route('pkl.assess.index', $group) }}" class="text-blue-600 text-sm hover:underline">Nilai →</a>
        </div>

        <form method="GET" class="mb-3 flex gap-2">
            <select name="class_id" class="border rounded px-3 py-2" onchange="this.form.submit()">
                @foreach ($classes as $id => $n)
                    <option value="{{ $id }}" @selected($classId == $id)>{{ $n }}</option>
                @endforeach
            </select>
        </form>

        <form method="POST" action="{{ route('pkl.members.enroll-class', $group) }}" class="mb-3">
            @csrf
            <input type="hidden" name="class_id" value="{{ $classId }}">
            <button class="px-3 py-2 rounded bg-emerald-600 text-white text-sm">Tambah semua siswa kelas terpilih</button>
        </form>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold mb-2">Sudah Terdaftar ({{ count($enrolled) }})</h3>
                <ul class="space-y-2">
                    @foreach ($enrolled as $s)
                        <li class="flex items-center justify-between border rounded px-3 py-2">
                            <span>{{ $s->nama }}</span>
                            <form method="POST" action="{{ route('pkl.members.destroy', [$group, $s->id]) }}">
                                @csrf @method('DELETE')
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
                <h3 class="font-semibold mb-2">Kandidat (kelas terpilih)</h3>
                <ul class="space-y-2">
                    @foreach ($candidates as $s)
                        <li class="flex items-center justify-between border rounded px-3 py-2">
                            <span>{{ $s->nama }}</span>
                            <form method="POST" action="{{ route('pkl.members.store', $group) }}">
                                @csrf
                                <input type="hidden" name="student_id" value="{{ $s->id }}">
                                <button class="text-blue-600 text-sm">Tambah</button>
                            </form>
                        </li>
                    @endforeach
                    @if (!count($candidates))
                        <li class="text-sm text-slate-500">Pilih kelas untuk melihat kandidat.</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection
