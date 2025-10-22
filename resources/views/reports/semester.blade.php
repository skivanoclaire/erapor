@php
    $fmtNama = fn($s) => $s?->nama ?? '-';
    $judul = $setting->judul_rapor ?? 'LAPORAN HASIL BELAJAR';
    $ttdKep = $setting?->ttd_kepsek_media_id ? $setting->ttdKepsekMedia?->path : null;
    $tglCet = now()->format('d F Y');

    function num($v)
    {
        return $v === null ? '-' : rtrim(rtrim(number_format($v, 2), '0'), '.');
    }
@endphp
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $judul }}</title>
    <style>
        @page {
            margin: {{ (float) ($setting->margin_top_cm ?? 1.5) }}cm 1.5cm;
        }

        body {
            font-family: {{ $setting->font_family ?? 'Arial' }}, sans-serif;
            font-size: {{ (float) ($setting->table_body_font_size ?? 12) }}pt;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .title {
            text-align: center;
            font-weight: 700;
            font-size: {{ (float) ($setting->title_font_size ?? 18) }}pt;
            margin: 6px 0 10px;
        }

        .meta td {
            padding: 2px 4px;
            vertical-align: top;
        }

        .border {
            border: 1px solid #000;
        }

        .th {
            background: #eee;
            font-weight: 700;
            text-align: center;
        }

        .p-6 {
            padding: 6px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .mb-8 {
            margin-bottom: 8px;
        }

        .mb-12 {
            margin-bottom: 12px;
        }

        .mt-24 {
            margin-top: 24px;
        }

        .page-break {
            page-break-after: always;
        }

        .small {
            font-size: 9pt;
            color: #444;
        }

        .signbox {
            height: 90px;
        }
    </style>
</head>

<body>

    {{-- =======================================================
   HALAMAN 1
======================================================= --}}
    <table class="meta mb-8">
        <tr>
            <td>Nama</td>
            <td>: {{ $student->nama }}</td>
            <td>Kelas</td>
            <td>: {{ $student->class->nama_kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td>NIS / NISN</td>
            <td>: {{ $student->id }} / {{ $student->nisn ?? '-' }}</td>
            <td>Fase</td>
            <td>: {{ strtoupper(substr($student->class->nama_kelas ?? '-', 0, 1)) }}</td>
        </tr>
        <tr>
            <td>Nama Sekolah</td>
            <td>: {{ $school->nama_sekolah }}</td>
            <td>Semester</td>
            <td>: {{ ucfirst($semester->semester) }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $school->alamat_jalan }}</td>
            <td>Tahun Pelajaran</td>
            <td>: {{ $semester->tahun_ajaran }}</td>
        </tr>
    </table>

    <div class="title">{{ $judul }}</div>

    <table class="border small">
        <tr class="th">
            <td class="border p-6" style="width:28px">No</td>
            <td class="border p-6">Mata Pelajaran</td>
            <td class="border p-6" style="width:65px">Nilai Akhir</td>
            <td class="border p-6" style="width:56%">Capaian Kompetensi</td>
        </tr>
        @foreach ($subjects as $i => $row)
            <tr>
                <td class="border center p-6">{{ $i + 1 }}.</td>
                <td class="border p-6">{{ $row->subject_name }}</td>
                <td class="border center p-6">{{ num($row->final) }}</td>
                <td class="border p-6">{{ $row->desc }}</td>
            </tr>
        @endforeach
    </table>

    <div class="small mt-24">
        | {{ $student->class->nama_kelas ?? '-' }} | {{ $student->nama }} | {{ $student->id }} Halaman: 1
    </div>

    <div class="page-break"></div>

    {{-- =======================================================
   HALAMAN 2
======================================================= --}}
    <table class="meta mb-8">
        <tr>
            <td>Nama</td>
            <td>: {{ $student->nama }}</td>
            <td>Kelas</td>
            <td>: {{ $student->class->nama_kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td>NIS / NISN</td>
            <td>: {{ $student->id }} / {{ $student->nisn ?? '-' }}</td>
            <td>Fase</td>
            <td>: {{ strtoupper(substr($student->class->nama_kelas ?? '-', 0, 1)) }}</td>
        </tr>
        <tr>
            <td>Nama Sekolah</td>
            <td>: {{ $school->nama_sekolah }}</td>
            <td>Semester</td>
            <td>: {{ ucfirst($semester->semester) }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $school->alamat_jalan }}</td>
            <td>Tahun Pelajaran</td>
            <td>: {{ $semester->tahun_ajaran }}</td>
        </tr>
    </table>

    {{-- Ekstrakurikuler --}}
    <table class="border small mb-12">
        <tr class="th">
            <td class="border p-6" style="width:28px">No</td>
            <td class="border p-6">Kegiatan Ekstrakurikuler</td>
            <td class="border p-6" style="width:100px">Predikat</td>
            <td class="border p-6">Keterangan</td>
        </tr>
        @forelse($extracurriculars as $i => $ex)
            <tr>
                <td class="border center p-6">{{ $i + 1 }}.</td>
                <td class="border p-6">{{ $ex->name }}</td>
                <td class="border center p-6">{{ $ex->grade ?? '-' }}</td>
                <td class="border p-6">{{ $ex->desc ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="border p-6">-</td>
            </tr>
        @endforelse
    </table>

    {{-- Absensi --}}
    <table class="small mb-12" style="width:50%">
        <tr>
            <td>Sakit</td>
            <td>: {{ (int) ($att->sakit ?? 0) }} Hari</td>
        </tr>
        <tr>
            <td>Izin</td>
            <td>: {{ (int) ($att->izin ?? 0) }} Hari</td>
        </tr>
        <tr>
            <td>Tanpa Keterangan</td>
            <td>: {{ (int) ($att->alpa ?? 0) }} Hari</td>
        </tr>
    </table>

    {{-- Catatan --}}
    <div class="small mb-12">
        <div style="font-weight:700;margin-bottom:6px;">Catatan Wali Kelas</div>
        <div class="border p-6" style="height:60px;">{{ $note->catatan_akhir ?? ($note->catatan_tengah ?? '') }}</div>
    </div>

    {{-- Keputusan --}}
    <div class="small mb-12">
        <div style="font-weight:700;margin-bottom:6px;">Keputusan</div>
        <div class="border p-6">
            Berdasarkan pencapaian hasil belajar semester ini, siswa ditetapkan:
            <b>{{ $prom && $prom->promoted ? 'Naik ke kelas ' . $student->class->nama_kelas : 'Tinggal Kelas' }}</b>
        </div>
    </div>

    {{-- Tanda tangan --}}
    <table class="small" style="width:100%; margin-top:24px;">
        <tr>
            <td class="center" style="width:33%;">Mengetahui<br>Orang Tua/Wali,<br>
                <div class="signbox"></div>........................
            </td>
            <td></td>
            <td class="center" style="width:33%;">Tanjung Selor, {{ $tglCet }}<br>Wali Kelas,<br>
                <div class="signbox"></div>
                <u>{{ $waliSig?->wali?->nama ?? '-' }}</u><br>
                NIP. {{ $waliSig?->wali?->nip ?? '-' }}
            </td>
        </tr>
        <tr>
            <td colspan="3" style="height:24px;"></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td class="center">Mengetahui<br>Kepala Sekolah<br>
                <div class="signbox"></div>
                <u>{{ $kepala?->nama ?? '-' }}</u><br>
                NIP. {{ $kepala?->nip ?? '-' }}
            </td>
        </tr>
    </table>

    <div class="small mt-24">
        | {{ $student->class->nama_kelas ?? '-' }} | {{ $student->nama }} | {{ $student->id }} Halaman: 2
    </div>
</body>

</html>
