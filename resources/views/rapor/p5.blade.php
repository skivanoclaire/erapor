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
            font-size: 10px;
            color: #000;
        }

        .center {
            text-align: center;
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

        .fw700 {
            font-weight: 700
        }

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

        .w2 {
            width: 2%
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

        .w40 {
            width: 40%
        }

        .w50 {
            width: 50%
        }

        .text-cap {
            text-transform: capitalize;
        }

        .page-break {
            page-break-after: always;
        }

        .legend-box {
            display: inline-block;
            border: 1px solid #000;
            padding: 8px;
            margin: 10px 0;
            font-size: 9px;
        }

        .legend-item {
            margin: 4px 0;
        }

        .dimension-header {
            writing-mode: vertical-rl;
            text-orientation: mixed;
            transform: rotate(180deg);
            font-size: 9px;
            padding: 4px;
        }

        .footer {
            position: fixed;
            bottom: 8mm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #333;
        }
    </style>
</head>

<body>

    @foreach($projects as $index => $project)
        @if($index > 0)
            <div class="page-break"></div>
        @endif

        {{-- ====== HEADER ====== --}}
        <h2 class="center fw700" style="margin: 0;">RAPOR PROJEK PENGUATAN PROFIL<br>PELAJAR PANCASILA</h2>

        <table class="no-border mt12" style="font-size: 10px;">
            <tr>
                <td class="w20"><strong>Nama Sekolah</strong></td>
                <td class="w2"></td>
                <td class="w40">{{ $school->nama_sekolah ?? ($school->nama ?? '-') }}</td>
                <td class="w20"><strong>Kelas</strong></td>
                <td class="w2"></td>
                <td>{{ $class->nama_kelas ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Alamat</strong></td>
                <td></td>
                <td>{{ $school->alamat_jalan ?? ($school->alamat ?? '-') }}</td>
                <td><strong>Fase</strong></td>
                <td></td>
                <td>{{ $fase }}</td>
            </tr>
            <tr>
                <td><strong>Nama Siswa</strong></td>
                <td></td>
                <td>{{ $student->nama }}</td>
                <td><strong>Tahun Ajaran</strong></td>
                <td></td>
                <td>{{ $semester->tahun_ajaran }}</td>
            </tr>
            <tr class="bb2">
                <td><strong>NISN</strong></td>
                <td></td>
                <td>{{ $student->nisn ?? '-' }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>

        {{-- ====== JUDUL PROJEK ====== --}}
        <div class="mt12 fw700" style="font-size: 11px;">
            Projek {{ $index + 1 }} | {{ $project['theme'] }}
        </div>

        <div style="font-size: 9px; margin-top: 4px; line-height: 1.4;">
            {{ $project['catatan_proses'] ?: 'Mampu mengembangkan keterampilan dalam mengolah limbah sampah plastik dan kertas sehingga menjadi produk yang memiliki nilai estetika sebagai upaya dalam menjaga lingkungan.' }}
        </div>

        {{-- ====== LEGEND ====== --}}
        <table class="no-border mt8" style="width: 100%;">
            <tr>
                <td style="width: 25%; vertical-align: top;">
                    <div style="font-size: 9px; font-weight: bold;">MB. Mulai Berkembang</div>
                    <div style="font-size: 8px;">Siswa masih membutuhkan bimbingan dalam mengembangkan kemampuan</div>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <div style="font-size: 9px; font-weight: bold;">SB. Sedang Berkembang</div>
                    <div style="font-size: 8px;">Siswa mulai mengembangkan kemampuan namun masih belum ajek</div>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <div style="font-size: 9px; font-weight: bold;">BSH. Berkembang Sesuai Harapan</div>
                    <div style="font-size: 8px;">Siswa telah mengembangkan kemampuan hingga berada dalam tahap ajek</div>
                </td>
                <td style="width: 25%; vertical-align: top;">
                    <div style="font-size: 9px; font-weight: bold;">SAB. Sangat Berkembang</div>
                    <div style="font-size: 8px;">Siswa mengembangkan kemampuannya melampaui harapan</div>
                </td>
            </tr>
        </table>

        {{-- ====== TABEL PENILAIAN ====== --}}
        <table class="mt12" style="font-size: 9px;">
            <thead>
                <tr>
                    <th rowspan="2" class="center" style="width: 50px;">Projek Kelas {{ $class->tingkat_pendidikan ?? 'XI' }}</th>
                    <th colspan="6" class="center">Dimensi Profil Pelajar Pancasila</th>
                </tr>
                <tr>
                    <th class="center" style="width: 80px;">
                        <div class="dimension-header">Beriman, Bertakwa Kepada Tuhan YME, dan Berakhlak Mulia</div>
                    </th>
                    <th class="center" style="width: 60px;">
                        <div class="dimension-header">Bernalar Kritis</div>
                    </th>
                    <th class="center" style="width: 60px;">
                        <div class="dimension-header">Mandiri</div>
                    </th>
                    <th class="center" style="width: 80px;">
                        <div class="dimension-header">Berkebinekaan Global</div>
                    </th>
                    <th class="center" style="width: 60px;">
                        <div class="dimension-header">Kreatif</div>
                    </th>
                    <th class="center" style="width: 80px;">
                        <div class="dimension-header">Bergotong Royong</div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-size: 8px; padding: 8px;">{{ $project['theme'] }}</td>
                    <td class="center fw700" style="font-size: 12px;">{{ $project['dimension_levels']['beriman'] ?? '-' }}</td>
                    <td class="center fw700" style="font-size: 12px;">{{ $project['dimension_levels']['bernalar_kritis'] ?? '-' }}</td>
                    <td class="center fw700" style="font-size: 12px;">{{ $project['dimension_levels']['mandiri'] ?? '-' }}</td>
                    <td class="center fw700" style="font-size: 12px;">{{ $project['dimension_levels']['berkebinekaan'] ?? '-' }}</td>
                    <td class="center fw700" style="font-size: 12px;">{{ $project['dimension_levels']['kreatif'] ?? '-' }}</td>
                    <td class="center fw700" style="font-size: 12px;">{{ $project['dimension_levels']['bergotong_royong'] ?? '-' }}</td>
                </tr>
            </tbody>
        </table>

        {{-- ====== TANDA TANGAN ====== --}}
        @php
            $kota = $school->kabkota ?? ($school->kota ?? '');
            $tgl = now()->translatedFormat('d F Y');
        @endphp

        <table class="no-border mt16" style="font-size: 10px;">
            <tr>
                <td class="w50"></td>
                <td class="w50 center">
                    {{ $kota ? $kota . ',' : 'Tanjung Selor,' }}<br>
                    Wali Kelas,<br><br><br><br>
                    <strong>{{ $waliKelas->nama ?? 'Rofik Angtiangsih, S.Pd.I' }}</strong><br>
                    NIP. {{ $waliKelas->nip ?? '-' }}
                </td>
            </tr>
        </table>

        {{-- ====== HALAMAN DETAIL (Halaman 2) ====== --}}
        <div class="page-break"></div>

        {{-- HEADER HALAMAN 2 --}}
        <div class="fw700" style="font-size: 11px;">
            {{ $index + 1 }}. {{ $project['theme'] }}
        </div>

        {{-- TABEL DETAIL KRITERIA --}}
        <table class="mt8" style="font-size: 9px;">
            <thead>
                <tr>
                    <th class="center" style="width: 200px;">Dimensi</th>
                    <th colspan="3" class="center">Sub Elemen</th>
                    <th class="center">MB</th>
                    <th class="center">SB</th>
                    <th class="center">BSH</th>
                    <th class="center">SAB</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $dimensions = [
                        1 => 'Beriman, Bertakwa Kepada Tuhan YME, dan Berakhlak Mulia',
                        2 => 'Bernalar Kritis',
                        3 => 'Mandiri',
                        4 => 'Berkebinekaan Global',
                        5 => 'Kreatif',
                        6 => 'Bergotong Royong',
                    ];
                @endphp
                @foreach($project['criteria'] as $crit)
                    <tr>
                        <td style="font-size: 8px;">{{ $dimensions[$crit['dimension_id']] ?? '-' }}</td>
                        <td colspan="3" style="font-size: 8px;">{{ $crit['title'] }}</td>
                        <td class="center">@if($crit['level'] == 'MB') ✔ @endif</td>
                        <td class="center">@if($crit['level'] == 'SB') ✔ @endif</td>
                        <td class="center">@if($crit['level'] == 'BSH') ✔ @endif</td>
                        <td class="center">@if($crit['level'] == 'SAB') ✔ @endif</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- CATATAN PROSES --}}
        <div class="mt12 fw700" style="font-size: 10px;">Catatan Proses</div>
        <div style="border: 1px solid #000; padding: 8px; min-height: 60px; font-size: 9px;">
            {{ $project['catatan_proses'] ?: 'Mampu mengembangkan keterampilan dalam mengolah limbah sampah plastik dan kertas sehingga menjadi produk yang memiliki nilai estetika sebagai upaya dalam menjaga lingkungan.' }}
        </div>

        {{-- TANDA TANGAN HALAMAN 2 --}}
        <table class="no-border mt16" style="font-size: 10px;">
            <tr>
                <td style="width: 33%; text-align: center;">
                    Mengetahui<br>
                    Orang Tua/Wali,<br><br><br><br><br>
                    @php
                        $namaOrtu = $student->nama_wali ?: ($student->nama_ayah ?: '........................');
                        $namaOrtu = $namaOrtu !== '........................' ? ucwords(strtolower($namaOrtu)) : $namaOrtu;
                    @endphp
                    <strong>{{ $namaOrtu }}</strong>
                </td>
                <td style="width: 34%; text-align: center;">
                    {{ $kota ? $kota . ',' : 'Tanjung Selor,' }}<br>
                    Wali Kelas,<br><br><br><br><br>
                    <strong>{{ $waliKelas->nama ?? 'Rofik Angtiangsih, S.Pd.I' }}</strong><br>
                    NIP. {{ $waliKelas->nip ?? '-' }}
                </td>
                <td style="width: 33%; text-align: center;">
                    Mengetahui<br>
                    Kepala Sekolah<br><br><br><br><br>
                    <strong>{{ $kepalaSekolah->nama ?? 'Nurhayati Ambo' }}</strong><br>
                    NIP. {{ $kepalaSekolah->nip ?? '-' }}
                </td>
            </tr>
        </table>

    @endforeach

</body>

</html>
