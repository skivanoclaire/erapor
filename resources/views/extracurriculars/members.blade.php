@extends('layouts.app')
@section('title', 'Anggota Ekskul')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold">{{ $ex->name }} — Anggota</h2>

            {{-- Link ke halaman nilai (hanya jika route ada) --}}
            @if (Route::has('ex.assess.index'))
                <a href="{{ route('ex.assess.index', $ex) }}" class="text-blue-600 text-sm hover:underline">Nilai →</a>
            @endif
        </div>

        {{-- Alerts --}}
        @if (session('ok'))
            <div class="mb-3 rounded border border-emerald-200 bg-emerald-50 text-emerald-800 px-3 py-2 text-sm">
                {{ session('ok') }}
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

        {{-- Filter --}}
        <form method="GET" class="mb-3 flex flex-wrap gap-2">
            <select name="semester_id" class="border rounded px-3 py-2">
                @foreach ($semesters as $sem)
                    <option value="{{ $sem->id }}" @selected($semesterId == $sem->id)>
                        {{ $sem->tahun_ajaran }} ({{ $sem->semester }})
                    </option>
                @endforeach
            </select>

            <select name="class_id" class="border rounded px-3 py-2">
                <option value="">— Pilih Kelas —</option>
                @foreach ($classes as $c)
                    <option value="{{ $c->id }}" @selected($classId == $c->id)>{{ $c->nama_kelas }}</option>
                @endforeach
            </select>

            <button class="px-3 py-2 border rounded">Filter</button>
        </form>

        {{-- Tambah semua siswa kelas terpilih --}}
        <form method="POST" action="{{ route('extracurriculars.members.storeAll', $ex) }}" class="mb-3">
            @csrf
            <input type="hidden" name="semester_id" value="{{ $semesterId }}">
            <input type="hidden" name="class_id" value="{{ $classId }}">
            <button class="px-3 py-2 rounded bg-emerald-600 text-white text-sm" @disabled(!$classId)>
                Tambah semua siswa kelas terpilih
            </button>
        </form>

        <div class="grid md:grid-cols-2 gap-6">
            {{-- Sudah terdaftar --}}
            <div>
                <h3 class="font-semibold mb-2">Sudah Terdaftar ({{ $members->count() }})</h3>
                <ul class="space-y-2">
                    @forelse ($members as $m)
                        <li class="flex items-center justify-between border rounded px-3 py-2">
                            <span>{{ $m->student->nama ?? '-' }}</span>
                            <form method="POST" action="{{ route('extracurriculars.members.destroy', [$ex, $m]) }}"
                                onsubmit="return confirm('Hapus anggota ini?')">
                                @csrf @method('DELETE')
                                {{-- agar kembali ke semester yg sama --}}
                                <input type="hidden" name="semester_id" value="{{ $semesterId }}">
                                <button class="text-rose-600 text-sm">Hapus</button>
                            </form>
                        </li>
                    @empty
                        <li class="text-sm text-slate-500">Belum ada.</li>
                    @endforelse
                </ul>
            </div>

            {{-- Kandidat --}}
            <div>
                <h3 class="font-semibold mb-2">Kandidat (berdasarkan kelas/sekolah)</h3>
                <ul class="space-y-2">
                    @forelse ($candidates as $s)
                        <li class="flex items-center justify-between border rounded px-3 py-2">
                            <span>{{ $s->nama }}</span>
                            <form method="POST" action="{{ route('extracurriculars.members.store', $ex) }}">
                                @csrf
                                <input type="hidden" name="semester_id" value="{{ $semesterId }}">
                                <input type="hidden" name="student_id" value="{{ $s->id }}">
                                <button class="text-blue-600 text-sm">Tambah</button>
                            </form>
                        </li>
                    @empty
                        <li class="text-sm text-slate-500">
                            Pilih kelas untuk menampilkan kandidat.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
