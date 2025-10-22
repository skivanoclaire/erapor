@extends('layouts.app')
@section('title', 'Dashboard Cetak Rapor')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">

        {{-- Filter --}}
        <form method="GET" class="grid md:grid-cols-4 gap-3 mb-4">
            <label class="text-sm">Semester
                <select name="semester_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($semesters as $sem)
                        <option value="{{ $sem->id }}" @selected($semesterId == $sem->id)>
                            {{ $sem->tahun_ajaran }} ({{ $sem->semester }})
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="text-sm">Kelas (opsional)
                <select name="class_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">— Semua —</option>
                    @foreach ($classes as $c)
                        <option value="{{ $c->id }}" @selected($classId == $c->id)>
                            {{ $c->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="text-sm">Siswa
                <select name="student_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">— Pilih Siswa —</option>
                    @foreach ($students as $st)
                        <option value="{{ $st->id }}" @selected($studentId == $st->id)>{{ $st->nama }}</option>
                    @endforeach
                </select>
            </label>

            <div class="flex items-end gap-2">
                <button class="px-3 py-2 border rounded">Terapkan</button>

                @if ($studentId && $semesterId)
                    <a target="_blank" class="px-3 py-2 border rounded"
                        href="{{ route('reports.semester.show', [$studentId, $semesterId]) }}">Preview</a>
                    <a class="px-3 py-2 rounded bg-blue-600 text-white"
                        href="{{ route('reports.semester.pdf', [$studentId, $semesterId]) }}">PDF</a>
                @endif
            </div>
        </form>

        {{-- Konten rapor (hasil join) --}}
        @if ($data)
            @php
                // helper angka
                $num = fn($v) => $v === null ? '-' : rtrim(rtrim(number_format($v, 2), '0'), '.');
            @endphp

            {{-- Header identitas --}}
            <div class="text-sm text-slate-700 mb-3">
                <div>Nama: <b>{{ $data['student']->nama }}</b> •
                    Kelas: <b>{{ $data['student']->class->nama_kelas ?? '-' }}</b> •
                    Semester: <b>{{ $data['semester']->tahun_ajaran }} ({{ $data['semester']->semester }})</b>
                </div>
                <div>Nama Sekolah: <b>{{ $data['school']->nama_sekolah }}</b> •
                    Alamat: <b>{{ $data['school']->alamat_jalan }}</b>
                </div>
            </div>

            <h3 class="text-center font-semibold mb-2">LAPORAN HASIL BELAJAR</h3>

            {{-- Tabel Mapel + Nilai + Capaian --}}
            <div class="overflow-x-auto mb-6">
                <table class="min-w-full border text-sm">
                    <thead>
                        <tr class="bg-slate-100">
                            <th class="border px-2 py-2 w-10">No</th>
                            <th class="border px-2 py-2">Mata Pelajaran</th>
                            <th class="border px-2 py-2 w-24">Nilai Akhir</th>
                            <th class="border px-2 py-2">Capaian Kompetensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['subjects'] as $i => $row)
                            <tr>
                                <td class="border px-2 py-2 text-center">{{ $i + 1 }}</td>
                                <td class="border px-2 py-2">{{ $row->subject_name }}</td>
                                <td class="border px-2 py-2 text-center">{{ $num($row->final) }}</td>
                                <td class="border px-2 py-2">{{ $row->desc }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Halaman 2: Ekskul, Absensi, Catatan, Keputusan (ringkas seperti PDF) --}}
            <div class="grid md:grid-cols-2 gap-6">

                {{-- Ekskul --}}
                <div>
                    <h4 class="font-semibold mb-2">Kegiatan Ekstrakurikuler</h4>
                    <table class="min-w-full border text-sm">
                        <thead>
                            <tr class="bg-slate-100">
                                <th class="border px-2 py-1 w-10">No</th>
                                <th class="border px-2 py-1">Kegiatan</th>
                                <th class="border px-2 py-1 w-24">Predikat</th>
                                <th class="border px-2 py-1">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['extracurriculars'] as $i=>$ex)
                                <tr>
                                    <td class="border px-2 py-1 text-center">{{ $i + 1 }}</td>
                                    <td class="border px-2 py-1">{{ $ex->name }}</td>
                                    <td class="border px-2 py-1 text-center">{{ $ex->grade ?? '-' }}</td>
                                    <td class="border px-2 py-1">{{ $ex->desc ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border px-2 py-2 text-center text-slate-500">-</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Absensi --}}
                <div>
                    <h4 class="font-semibold mb-2">Absensi</h4>
                    <table class="border text-sm">
                        <tr>
                            <td class="border px-3 py-1">Sakit</td>
                            <td class="border px-3 py-1">{{ (int) ($data['att']->sakit ?? 0) }} Hari</td>
                        </tr>
                        <tr>
                            <td class="border px-3 py-1">Izin</td>
                            <td class="border px-3 py-1">{{ (int) ($data['att']->izin ?? 0) }} Hari</td>
                        </tr>
                        <tr>
                            <td class="border px-3 py-1">Tanpa Keterangan</td>
                            <td class="border px-3 py-1">{{ (int) ($data['att']->alpa ?? 0) }} Hari</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Catatan & Keputusan --}}
            <div class="grid md:grid-cols-2 gap-6 mt-6">
                <div>
                    <h4 class="font-semibold mb-2">Catatan Wali Kelas</h4>
                    <div class="border rounded px-3 py-3 min-h-[90px]">
                        {{ $data['note']->catatan_akhir ?? ($data['note']->catatan_tengah ?? '-') }}
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold mb-2">Keputusan</h4>
                    <div class="border rounded px-3 py-3 min-h-[90px]">
                        Berdasarkan pencapaian hasil belajar semester ini, siswa ditetapkan:
                        <b>{{ $data['prom'] && $data['prom']->promoted ? 'Naik Kelas' : 'Tinggal Kelas' }}</b>
                    </div>
                </div>
            </div>
        @else
            <div class="text-slate-500 text-sm">Silakan pilih Semester, (opsional) Kelas, lalu pilih Siswa dan klik
                <b>Terapkan</b>.</div>
        @endif
    </div>
@endsection
