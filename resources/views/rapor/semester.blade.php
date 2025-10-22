<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        /* --- KERTAS F4 --- */
        @page {
            size: 210mm 330mm;
            margin: 12mm;
        }

        * {
            font-family: "DejaVu Sans", Arial, sans-serif;
        }

        body {
            margin: 0;
            font-size: 11px;
            color: #000;
        }

        /* --- UTIL --- */
        .row {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .col {
            display: table-cell;
            vertical-align: top;
        }

        .left {
            text-align: left;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .mt4 {
            margin-top: 4px
        }

        .mt6 {
            margin-top: 6px
        }

        .mt8 {
            margin-top: 8px
        }

        .mt12 {
            margin-top: 12px
        }

        .mt16 {
            margin-top: 16px
        }

        .mt24 {
            margin-top: 24px
        }

        .small {
            font-size: 10px
        }

        .xs {
            font-size: 9px
        }

        /* --- TABEL --- */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        .no-border th,
        .no-border td {
            border: 0;
            padding: 2px 0;
        }

        .bb2 {
            border-bottom: 2px solid #000;
        }

        .bt2 {
            border-top: 2px solid #000;
        }

        .fw700 {
            font-weight: 700
        }

        /* --- GRID LEBAR --- */
        .w2 {
            width: 2%
        }

        .w5 {
            width: 5%
        }

        .w8 {
            width: 8%
        }

        .w10 {
            width: 10%
        }

        .w12 {
            width: 12%
        }

        .w15 {
            width: 15%
        }

        .w16 {
            width: 16%
        }

        .w18 {
            width: 18%
        }

        .w20 {
            width: 20%
        }

        .w25 {
            width: 25%
        }

        .w30 {
            width: 30%
        }

        .w33 {
            width: 33.33%
        }

        .w35 {
            width: 35%
        }

        .w40 {
            width: 40%
        }

        .w50 {
            width: 50%
        }

        .w60 {
            width: 60%
        }

        /* --- BLOK CATATAN --- */
        .note-box {
            min-height: 60px;
            border: 1px solid #000;
            padding: 6px
        }

        .text-cap {
            text-transform: capitalize;
        }

        /* Footer page */
        .footer {
            position: fixed;
            bottom: 8mm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #333;
        }

        /* Page break */
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    {{-- ====== HALAMAN 1: LAPORAN HASIL BELAJAR ====== --}}
    <table class="no-border small">
        <tr>
            <td class="w20">Nama</td>
            <td class="w2">:</td>
            <td class="w40">{{ $student->nama }}</td>
            <td class="w20">Kelas</td>
            <td class="w2">:</td>
            <td class="w16">{{ $class->nama_kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td>NIS / NISN</td>
            <td>:</td>
            <td>{{ $student->nis ?? '-' }} / {{ $student->nisn ?? '-' }}</td>
            <td>Fase</td>
            <td>:</td>
            <td>{{ $fase }}</td>
        </tr>
        <tr>
            <td>Nama Sekolah</td>
            <td>:</td>
            <td>{{ $school->nama_sekolah ?? ($school->nama ?? '-') }}</td>
            <td>Semester</td>
            <td>:</td>
            <td class="text-cap">{{ $semester->semester }}</td>
        </tr>
        <tr class="bb2">
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $school->alamat_jalan ?? ($school->alamat ?? '-') }}</td>
            <td>Tahun Pelajaran</td>
            <td>:</td>
            <td>{{ $semester->tahun_ajaran }}</td>
        </tr>
    </table>

    {{-- ====== JUDUL ====== --}}
    <h2 class="center mt8 fw700">LAPORAN HASIL BELAJAR</h2>

    {{-- ====== TABEL NILAI MATA PELAJARAN ====== --}}
    <table class="mt8 xs">
        <thead>
            <tr>
                <th class="w5 center">No</th>
                <th class="w30">Mata Pelajaran</th>
                <th class="w10 center">Nilai Akhir</th>
                <th>Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subjects as $i => $subj)
                <tr>
                    <td class="center">{{ $i + 1 }}.</td>
                    <td>{{ $subj['nama_mapel'] }}</td>
                    <td class="center fw700">{{ $subj['nilai_akhir'] ?? '-' }}</td>
                    <td>{{ $subj['capaian'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="center">Belum ada data nilai.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ====== PAGE BREAK ====== --}}
    <div class="page-break"></div>

    {{-- ====== HALAMAN 2: EKSTRAKURIKULER & KEPUTUSAN ====== --}}
    <table class="no-border small">
        <tr>
            <td class="w20">Nama</td>
            <td class="w2">:</td>
            <td class="w40">{{ $student->nama }}</td>
            <td class="w20">Kelas</td>
            <td class="w2">:</td>
            <td class="w16">{{ $class->nama_kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td>NIS / NISN</td>
            <td>:</td>
            <td>{{ $student->nis ?? '-' }} / {{ $student->nisn ?? '-' }}</td>
            <td>Fase</td>
            <td>:</td>
            <td>{{ $fase }}</td>
        </tr>
        <tr>
            <td>Nama Sekolah</td>
            <td>:</td>
            <td>{{ $school->nama_sekolah ?? ($school->nama ?? '-') }}</td>
            <td>Semester</td>
            <td>:</td>
            <td class="text-cap">{{ $semester->semester }}</td>
        </tr>
        <tr class="bb2">
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $school->alamat_jalan ?? ($school->alamat ?? '-') }}</td>
            <td>Tahun Pelajaran</td>
            <td>:</td>
            <td>{{ $semester->tahun_ajaran }}</td>
        </tr>
    </table>

    {{-- ====== TABEL EKSTRAKURIKULER ====== --}}
    <table class="mt12 small">
        <thead>
            <tr>
                <th class="w5 center">No</th>
                <th class="w30">Kegiatan Ekstrakurikuler</th>
                <th class="w15 center">Predikat</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $maxEkstra = max(2, $ekstra->count());
            @endphp
            @for ($i = 0; $i < $maxEkstra; $i++)
                @php
                    $ex = $ekstra[$i] ?? null;
                @endphp
                <tr>
                    <td class="center">{{ $i + 1 }}.</td>
                    <td>{{ $ex->nama ?? '-' }}</td>
                    <td class="center">{{ $ex->predikat ?? '-' }}</td>
                    <td>{{ $ex->keterangan ?? '-' }}</td>
                </tr>
            @endfor
        </tbody>
    </table>

    {{-- ====== ABSENSI ====== --}}
    <table class="no-border mt12 small" style="width:40%; border: 1px solid #000;">
        <tr>
            <td class="w50" style="border: 0; padding: 4px 8px;">Sakit</td>
            <td class="w5" style="border: 0; padding: 4px 8px;">:</td>
            <td style="border: 0; padding: 4px 8px;">{{ $attendance->sakit ?? 0 }} Hari</td>
        </tr>
        <tr>
            <td style="border: 0; padding: 4px 8px;">Izin</td>
            <td style="border: 0; padding: 4px 8px;">:</td>
            <td style="border: 0; padding: 4px 8px;">{{ $attendance->izin ?? 0 }} Hari</td>
        </tr>
        <tr>
            <td style="border: 0; padding: 4px 8px;">Tanpa Keterangan</td>
            <td style="border: 0; padding: 4px 8px;">:</td>
            <td style="border: 0; padding: 4px 8px;">{{ $attendance->alpa ?? 0 }} Hari</td>
        </tr>
    </table>

    {{-- ====== CATATAN WALI KELAS ====== --}}
    <div class="mt12 fw700">Catatan Wali Kelas</div>
    <div class="note-box">{{ $note->catatan_akhir ?? '' }}</div>

    {{-- ====== KEPUTUSAN ====== --}}
    <div class="mt12 fw700">Keputusan</div>
    <div class="note-box">
        @if($promotion)
            Berdasarkan pencapaian hasil belajar dari semester ganjil dan genap, siswa ditetapkan:<br>
            <strong>
                @if($promotion->promoted)
                    Naik ke kelas {{ $promotion->next_class_id ? \App\Models\SchoolClass::find($promotion->next_class_id)->nama_kelas ?? '12 (dua belas)' : '12 (dua belas)' }} / <s>Tinggal Kelas</s>
                @else
                    <s>Naik ke kelas 12 (dua belas)</s> / Tinggal Kelas
                @endif
            </strong>
        @else
            Berdasarkan pencapaian hasil belajar dari semester ganjil dan genap, siswa ditetapkan:<br>
            <strong>Naik ke kelas 12 (dua belas) / Tinggal Kelas</strong>
        @endif
    </div>

    {{-- ====== TANDA TANGAN ====== --}}
    @php
        use Carbon\Carbon;
        $kota = $school->kabkota ?? ($school->kota ?? '');
        $tgl = $reportDate ? Carbon::parse($reportDate)->translatedFormat('d F Y') : '';
        if (!$tgl) $tgl = now()->translatedFormat('d F Y');
    @endphp

    <table class="no-border mt16 small">
        <tr>
            <td class="w33">
                <div class="center">
                    Mengetahui<br>
                    Orang Tua/Wali,<br><br><br><br><br>
                    @php
                        $namaOrtu = $student->nama_wali ?: ($student->nama_ayah ?: '........................');
                        $namaOrtu = $namaOrtu !== '........................' ? ucwords(strtolower($namaOrtu)) : $namaOrtu;
                    @endphp
                    <strong>{{ $namaOrtu }}</strong>
                </div>
            </td>
            <td class="w33">
                <div class="center">
                    {{ $kota ? $kota . ', ' : '' }}<br>
                    Wali Kelas,<br><br><br><br><br>
                    <strong>{{ $waliKelas->nama ?? 'Rofik Angtiangsih, S.Pd.I' }}</strong><br>
                    NIP. {{ $waliKelas->nip ?? '-' }}
                </div>
            </td>
            <td class="w33">
                <div class="center">
                    Mengetahui<br>
                    Kepala Sekolah<br><br><br><br><br>
                    <strong>{{ $kepalaSekolah->nama ?? 'Nurhayati Ambo' }}</strong><br>
                    NIP. {{ $kepalaSekolah->nip ?? '-' }}
                </div>
            </td>
        </tr>
    </table>

</body>

</html>
