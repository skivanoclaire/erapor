<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        @page {
            size: 210mm 330mm;
            margin: 12mm;
        }

        /* F4 */
        body {
            margin: 0;
        }

        * {
            font-family: "DejaVu Sans", Arial, sans-serif;
        }

        .center {
            text-align: center;
        }

        .title {
            font-size: 28px;
            font-weight: 700;
        }

        .subtitle {
            font-size: 18px;
            font-weight: 700;
        }

        .box {
            border: 1px solid #000;
            padding: 8px;
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
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    @php
        use Carbon\Carbon;

        // JK → teks
        $jkText = $student->jk === 'L' ? 'Laki-laki' : ($student->jk === 'P' ? 'Perempuan' : '-');

        // TTL → "Tempat, dd-mm-YYYY"
        $ttl = trim(
            ($student->tempat_lahir ?? '') .
                ($student->tempat_lahir && $student->tanggal_lahir ? ', ' : '') .
                ($student->tanggal_lahir ? Carbon::parse($student->tanggal_lahir)->format('d-m-Y') : ''),
        );

        // Telepon rumah: telepon_rumah → nomor_rumah → '-'
        $telpRumah = $student->telepon_rumah ?? ($student->nomor_rumah ?? '-');

        // Tanggal diterima (identitas PD)
        $tglMasuk = $student->tanggal_masuk_sekolah
            ? Carbon::parse($student->tanggal_masuk_sekolah)->format('d-m-Y')
            : '-';
    @endphp

    {{-- ===== Hal.1: Sampul ===== --}}
    <div class="center">
        <img src="{{ asset('img/logo-kemdikbud.png') }}" style="height:120px;">
        <div class="title" style="margin-top:24px;">RAPOR</div>
        <div class="subtitle">SEKOLAH MENENGAH KEJURUAN<br>( SMK )</div>

        <img src="{{ asset('img/logo-sekolah.png') }}" style="height:120px; margin-top:24px;">

        <div class="subtitle" style="margin-top:16px;">Kompetensi Keahlian</div>
        <div class="title" style="font-size:22px">
            {{ strtoupper($student->class->jurusan ?? ($student->class->nama_kelas ?? '-')) }}
        </div>

        <div class="subtitle" style="margin-top:24px;">Nama Peserta Didik</div>
        <div class="box" style="font-size:20px; margin-top:8px;">{{ $student->nama }}</div>

        <div class="subtitle" style="margin-top:16px;">NIS / NISN</div>
        <div class="box" style="font-size:20px; margin-top:8px;">
            {{ $student->nis ?? '-' }} / {{ $student->nisn ?? '-' }}
        </div>

        <div class="subtitle" style="margin-top:24px;">
            KEMENTERIAN PENDIDIKAN,<br>KEBUDAYAAN, RISET, DAN TEKNOLOGI<br>REPUBLIK INDONESIA
        </div>
    </div>
    <div class="page-break"></div>

    {{-- ===== Hal.2: Identitas Sekolah ===== --}}
    <h2 class="center">RAPOR</h2>
    <table class="no-border" style="font-size:14px">
        <tr>
            <td style="width:35%">Nama Sekolah</td>
            <td style="width:2%">:</td>
            <td>{{ $school->nama_sekolah }}</td>
        </tr>
        <tr>
            <td>NPSN</td>
            <td>:</td>
            <td>{{ $school->npsn }}</td>
        </tr>
        <tr>
            <td>NIS/NSS/NDS</td>
            <td>:</td>
            <td>{{ $school->nss ?? '-' }}</td>
        </tr>
        <tr>
            <td>Alamat Sekolah</td>
            <td>:</td>
            <td>{{ $school->alamat_jalan }}</td>
        </tr>
        <tr>
            <td>Kelurahan / Desa</td>
            <td>:</td>
            <td>{{ $school->desa_kelurahan }}</td>
        </tr>
        <tr>
            <td>Kecamatan</td>
            <td>:</td>
            <td>{{ $school->kecamatan }}</td>
        </tr>
        <tr>
            <td>Kota / Kabupaten</td>
            <td>:</td>
            <td>{{ $school->kabupaten_kota }}</td>
        </tr>
        <tr>
            <td>Provinsi</td>
            <td>:</td>
            <td>{{ $school->provinsi }}</td>
        </tr>
        <tr>
            <td>Website</td>
            <td>:</td>
            <td>{{ $school->website ?? '-' }}</td>
        </tr>
        <tr>
            <td>E-mail</td>
            <td>:</td>
            <td>{{ $school->email ?? '-' }}</td>
        </tr>

        {{-- Tambahan dari report_dates --}}
        <tr>
            <td>Tanggal Rapor Tengah Semester</td>
            <td>:</td>
            <td>{{ $reportMidDate ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tanggal Rapor Semester</td>
            <td>:</td>
            <td>{{ $reportFinalDate ?? '-' }}</td>
        </tr>

        {{-- Kepala sekolah (dari school_heads bila ada) --}}
        <tr>
            <td>Kepala Sekolah</td>
            <td>:</td>
            <td>
                {{ $kepsekNama ?? '-' }}
                @if (!empty($kepsekNip))
                    &nbsp;&nbsp;(NIP. {{ $kepsekNip }})
                @endif
            </td>
        </tr>
    </table>
    <div class="page-break"></div>

    {{-- ===== Hal.3: Identitas Peserta Didik ===== --}}
    <h2 class="center">IDENTITAS PESERTA DIDIK</h2>
    <table class="no-border" style="font-size:14px">
        <tr>
            <td>1. Nama Lengkap Peserta Didik</td>
            <td>:</td>
            <td>{{ $student->nama }}</td>
        </tr>
        <tr>
            <td>2. NIS / NISN</td>
            <td>:</td>
            <td>{{ $student->nis ?? '-' }} / {{ $student->nisn ?? '-' }}</td>
        </tr>
        <tr>
            <td>3. Tempat, Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $ttl !== '' ? $ttl : '-' }}</td>
        </tr>
        <tr>
            <td>4. Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $jkText }}</td>
        </tr>
        <tr>
            <td>5. Agama</td>
            <td>:</td>
            <td>{{ $student->agama ?? '-' }}</td>
        </tr>
        <tr>
            <td>6. Status dalam Keluarga</td>
            <td>:</td>
            <td>{{ $student->status_dalam_keluarga ?? '-' }}</td>
        </tr>
        <tr>
            <td>7. Anak ke</td>
            <td>:</td>
            <td>{{ $student->anak_ke ?? '-' }}</td>
        </tr>
        <tr>
            <td>8. Alamat Peserta Didik</td>
            <td>:</td>
            <td>{{ $student->alamat ?? '-' }}</td>
        </tr>
        <tr>
            <td>9. Nomor Telepon Rumah</td>
            <td>:</td>
            <td>{{ $telpRumah }}</td>
        </tr>
        <tr>
            <td>10. Sekolah Asal</td>
            <td>:</td>
            <td>{{ $student->sekolah_asal ?? '-' }}</td>
        </tr>
        <tr>
            <td>11. Diterima di sekolah ini</td>
            <td>:</td>
            <td>Di kelas: {{ $student->diterima_di_kelas ?? '-' }} | Pada tanggal: {{ $tglMasuk }}</td>
        </tr>
        <tr>
            <td>12. Nama Orang Tua</td>
            <td>:</td>
            <td>Ayah: {{ $student->nama_ayah ?? '-' }} | Ibu: {{ $student->nama_ibu ?? '-' }}</td>
        </tr>
        <tr>
            <td>13. Alamat Orang Tua</td>
            <td>:</td>
            <td>{{ $student->alamat_orang_tua ?? '-' }}</td>
        </tr>
        <tr>
            <td>15. Pekerjaan Orang Tua</td>
            <td>:</td>
            <td>Ayah: {{ $student->pekerjaan_ayah ?? '-' }} | Ibu: {{ $student->pekerjaan_ibu ?? '-' }}</td>
        </tr>
        <tr>
            <td>16–19. Data Wali</td>
            <td>:</td>
            <td>{{ $student->nama_wali ?? '-' }} | {{ $student->pekerjaan_wali ?? '-' }}</td>
        </tr>
    </table>
    <div style="margin-top:32px; text-align:right;">
        {{ $school->kabupaten_kota ?? '-' }}, {{ $signDate ?? now()->format('d F Y') }}<br>
        Kepala Sekolah,<br><br><br><br><br>
        <strong>{{ $kepsekNama ?? '................................' }}</strong><br>
        NIP. {{ $kepsekNip ?? '-' }}
    </div>
    <div class="page-break"></div>

    {{-- ===== Hal.4: Keterangan Pindah Sekolah - KELUAR ===== --}}
    <h2 class="center">KETERANGAN PINDAH SEKOLAH</h2>
    <div>Nama Peserta Didik : {{ $student->nama }}</div>
    <table style="margin-top:8px; font-size:13px">
        <tr>
            <th style="width:15%">Tanggal</th>
            <th style="width:20%">Kelas yang ditinggalkan</th>
            <th style="width:25%">Alasan</th>
            <th style="width:40%">Tanda Tangan Kepala Sekolah, Stempel Sekolah, dan Tanda Tangan Orang Tua/Wali</th>
        </tr>
        @for ($i = 0; $i < 3; $i++)
            <tr>
                <td style="height:220px"></td>
                <td></td>
                <td></td>
                <td>
                    __________, ______________<br>
                    Kepala Sekolah,<br><br><br>
                    NIP.<br><br>
                    Orang Tua/Wali,
                </td>
            </tr>
        @endfor
    </table>
    <div class="page-break"></div>

    {{-- ===== Hal.5: Keterangan Pindah Sekolah - MASUK ===== --}}
    <h2 class="center">KETERANGAN PINDAH SEKOLAH</h2>
    <div>Nama Peserta Didik : {{ $student->nama }}</div>
    <table style="margin-top:8px; font-size:13px">
        <tr>
            <th style="width:8%">NO</th>
            <th style="width:62%">MASUK</th>
            <th style="width:30%"></th>
        </tr>
        @for ($i = 1; $i <= 3; $i++)
            <tr>
                <td class="center">{{ $i }}</td>
                <td>
                    Nama Peserta Didik : .........................................<br>
                    Nomor Induk : .........................................<br>
                    Nama Sekolah : .........................................<br>
                    Masuk di Sekolah ini :<br>
                    a. Tanggal : .........................................<br>
                    b. Di Kelas : .........................................<br>
                    c. Tahun Pelajaran : .........................................
                </td>
                <td>
                    __________, ______________<br>
                    Kepala Sekolah,<br><br><br>
                    NIP.
                </td>
            </tr>
        @endfor
    </table>

</body>

</html>
