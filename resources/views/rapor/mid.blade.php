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
            font-size: 12px;
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
            font-size: 11px
        }

        .xs {
            font-size: 10px
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
            vertical-align: middle;
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
        .w5 {
            width: 5%
        }

        .w6 {
            width: 6%
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

        /* --- BLOK CATATAN --- */
        .note-box {
            min-height: 88px;
            border: 1px solid #000;
            padding: 6px
        }

        /* --- FOOTER --- */
        .footer {
            position: fixed;
            bottom: 10mm;
            left: 12mm;
            right: 12mm;
            font-size: 10px;
            color: #333;
        }
    </style>
</head>

<body>

    {{-- ====== HEADER IDENTITAS (kiri/kanan) ====== --}}
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
            <td>{{ $fase ?? '-' }}</td>
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
    <h2 class="center mt8 fw700">LAPORAN HASIL BELAJAR TENGAH SEMESTER</h2>

    {{-- ====== TABEL NILAI ====== --}}
    <table class="mt8">
        <thead>
            <tr>
                <th class="w5 center" rowspan="2">No</th>
                <th rowspan="2">Mata Pelajaran</th>
                <th class="center bt0" colspan="5">Rincian Nilai Sumatif</th>
                <th class="w10 center" rowspan="2">Rerata Nilai</th>
            </tr>
            <tr>
                <th class="w6 center">1</th>
                <th class="w6 center">2</th>
                <th class="w6 center">3</th>
                <th class="w6 center">4</th>
                <th class="w6 center">5</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $i => $r)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>{{ $r['mapel'] }}</td>
                    @for ($k = 0; $k < 5; $k++)
                        <td class="center">{{ is_null($r['s'][$k] ?? null) ? '' : number_format($r['s'][$k]) }}</td>
                    @endfor
                    <td class="center fw700">{{ !is_null($r['avg']) ? number_format($r['avg']) : '' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="center">Belum ada nilai.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ====== TABEL EKSTRAKURIKULER ====== --}}
    <table class="mt12">
        <thead>
            <tr>
                <th class="w5 center">No</th>
                <th>Kegiatan Ekstrakurikuler</th>
                <th class="w15 center">Predikat</th>
                <th class="w35">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php $maxRow = max(3, count($ekstra ?? [])); @endphp
            @for ($i = 0; $i < $maxRow; $i++)
                @php
                    $ex = $ekstra[$i] ?? ['nama' => '-', 'predikat' => '-', 'ket' => '-'];
                @endphp
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>{{ $ex['nama'] ?? '-' }}</td>
                    <td class="center">{{ $ex['predikat'] ?? '-' }}</td>
                    <td>{{ $ex['ket'] ?? '-' }}</td>
                </tr>
            @endfor
        </tbody>
    </table>

    {{-- ====== ABSENSI ====== --}}
    <table class="no-border mt12 small" style="width:50%;">
        <tr>
            <td class="w25">Sakit</td>
            <td class="w2">:</td>
            <td>{{ $att->sakit ?? 0 }} Hari</td>
        </tr>
        <tr>
            <td>Izin</td>
            <td>:</td>
            <td>{{ $att->izin ?? 0 }} Hari</td>
        </tr>
        <tr>
            <td>Tanpa Keterangan</td>
            <td>:</td>
            <td>{{ $att->alpa ?? 0 }} Hari</td>
        </tr>
    </table>

    {{-- ====== CATATAN WALI ====== --}}
    <div class="mt8 fw700">Catatan Wali Kelas</div>
    <div class="note-box">{{ $waliNote ?? '' }}</div>

    {{-- ====== TANDA TANGAN ====== --}}
    @php
        use Carbon\Carbon;
        $kota = $school->kabkota ?? ($school->kota ?? '');
        $tgl = $reportDate ? Carbon::parse($reportDate)->translatedFormat('d F Y') : now()->translatedFormat('d F Y');
    @endphp

    <table class="no-border mt16 small">
        <tr>
            <td class="w33 center">
                Mengetahui<br>Orang Tua/Wali,<br><br><br><br><br>
                @php
                    $namaOrtu = $student->nama_wali ?: ($student->nama_ayah ?: '........................');
                    $namaOrtu = $namaOrtu !== '........................' ? ucwords(strtolower($namaOrtu)) : $namaOrtu;
                @endphp
                <strong>{{ $namaOrtu }}</strong>
            </td>
            <td class="w33 center">
                {{ $kota ? $kota . ', ' : '' }}{{ $tgl }}<br>
                Wali Kelas,<br><br><br><br><br>
                @php
                    // Format nama: jika ada gelar, pisahkan dan format hanya nama
                    $namaWali = $waliNama ?? 'Rofik Angtiangsih, S.Pd.I';
                    if (preg_match('/(.*?),\s*(.*)/', $namaWali, $matches)) {
                        // Ada gelar setelah koma
                        $namaWali = ucwords(strtolower($matches[1])) . ', ' . $matches[2];
                    } else {
                        // Tidak ada gelar atau gelar di depan
                        $namaWali = ucwords(strtolower($namaWali));
                    }
                @endphp
                <strong>{{ $namaWali }}</strong><br>
                NIP. {{ $waliNip ?? '-' }}
            </td>
            <td class="w33 center">
                Mengetahui<br>Kepala Sekolah<br><br><br><br><br>
                @php
                    // Format nama: jika ada gelar, pisahkan dan format hanya nama
                    $namaKepsek = $kepsekNama ?? 'Nurhayati Ambo';
                    if (preg_match('/(.*?),\s*(.*)/', $namaKepsek, $matches)) {
                        // Ada gelar setelah koma
                        $namaKepsek = ucwords(strtolower($matches[1])) . ', ' . $matches[2];
                    } else {
                        // Tidak ada gelar atau gelar di depan
                        $namaKepsek = ucwords(strtolower($namaKepsek));
                    }
                @endphp
                <strong>{{ $namaKepsek }}</strong><br>
                NIP. {{ $kepsekNip ?? '-' }}
            </td>
        </tr>
    </table>


</body>

</html>
