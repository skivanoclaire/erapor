@extends('layouts.app')
@section('title', 'Manajemen Rapor')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">

        {{-- Header + pilih kelas --}}
        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
            <div>
                <div class="text-lg font-semibold">{{ $semester->school->nama_sekolah ?? '—' }}</div>
                <div class="text-sm text-slate-600">
                    Semester: <b>{{ $semester->tahun_ajaran }} ({{ $semester->semester }})</b>
                </div>
            </div>
            <form method="GET" class="flex items-center gap-2">
                <select name="class_id" class="border rounded px-3 py-2">
                    @foreach ($classes as $c)
                        <option value="{{ $c->id }}" @selected($classId == $c->id)>{{ $c->nama_kelas }}</option>
                    @endforeach
                </select>
                <button class="px-3 py-2 border rounded">Terapkan</button>
            </form>
        </div>

        {{-- Toolbar kecil (opsional) --}}
        @if ($classId)
            <div class="text-sm mb-3">
                Kelas <b>{{ optional($classes->firstWhere('id', $classId))->nama_kelas }}</b>
                • Cetak <a class="text-blue-600 hover:underline" href="#"
                    onclick="alert('Cetak per Anak sudah ada di tombol tiap baris. Cetak per Kelas bisa kita buat menyusul (merge PDF).'); return false;">per
                    Anak</a>
                / <a class="text-blue-600 hover:underline" href="#"
                    onclick="alert('Cetak per Kelas (bulk) belum diaktifkan.'); return false;">per Kelas</a>
            </div>
        @endif

        {{-- TABEL --}}
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border">
                <thead>
                    <tr class="bg-orange-100">
                        <th class="border px-2 py-2 w-10 text-center">No</th>
                        <th class="border px-2 py-2">Nama Peserta Didik</th>
                        <th class="border px-2 py-2 w-40 text-center">Pelengkap Rapor</th>
                        <th class="border px-2 py-2 w-40 text-center">Tengah Semester</th>
                        <th class="border px-2 py-2 w-32 text-center">Semester</th>
                        <th class="border px-2 py-2 w-24 text-center">P5BK</th>
                        <th class="border px-2 py-2 w-28 text-center">Buku Induk</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $i=>$s)
                        <tr class="{{ $i % 2 ? 'bg-orange-50' : '' }}">
                            <td class="border px-2 py-2 text-center">{{ $i + 1 }}</td>
                            <td class="border px-2 py-2">{{ $s->nama }}</td>

                            {{-- Pelengkap rapor (menu setting, tanda tangan, tanggal) --}}
                            <td class="border px-2 py-2 text-center">
                                <a href="{{ route('rapor.pelengkap.pdf', $s->id) }}"
                                    class="inline-block px-3 py-1 rounded bg-amber-500 text-white">Pelengkap Rapor</a>
                            </td>

                            {{-- Tengah semester (preview) -> sementara arahkan ke report final dengan query ?mid=1 (bisa kita aktifkan nanti) --}}
                            <td class="border px-2 py-2 text-center">
                                <a target="_blank" href="{{ route('rapor.mid.pdf', [$s->id, $semester->id]) }}"
                                    class="inline-block px-3 py-1 rounded bg-green-600 text-white">Tengah Semester</a>
                            </td>

                            {{-- Semester (preview final) --}}
                            <td class="border px-2 py-2 text-center">
                                <a target="_blank" href="{{ route('reports.semester.show', [$s->id, $semester->id]) }}"
                                    class="inline-block px-3 py-1 rounded bg-blue-600 text-white">Semester</a>
                            </td>

                            {{-- P5BK (sementara arahkan ke modul P5 projek) --}}
                            <td class="border px-2 py-2 text-center">
                                <a href="{{ route('p5-projects.index') }}"
                                    class="inline-block px-3 py-1 rounded bg-rose-600 text-white">P5BK</a>
                            </td>

                            {{-- Buku Induk (placeholder / edit siswa) --}}
                            <td class="border px-2 py-2 text-center">
                                <a href="{{ route('students.edit', $s) }}"
                                    class="inline-block px-3 py-1 rounded bg-yellow-400 text-black">Buku Induk</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="border px-3 py-6 text-center text-slate-500">Belum ada siswa pada
                                kelas ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
