<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <style>
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

        .fw700 {
            font-weight: 700;
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

        .page-break {
            page-break-after: always;
        }

        .header-title {
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        .info-table {
            width: 100%;
            font-size: 10px;
            margin-bottom: 10px;
        }

        .info-table td {
            border: 0;
            padding: 2px 0;
        }

        .section-title {
            font-weight: bold;
            font-size: 10px;
            margin: 10px 0 5px 0;
        }
    </style>
</head>

<body>
    @php
        // Simplified grouping - assume sequential order
        $allSemesters = $semesterData;
    @endphp

    @foreach($allSemesters as $index => $data)
        @if($index > 0)
            <div class="page-break"></div>
        @endif

        @php
            $semester = $data['semester'];
            // Semester bisa berupa 'ganjil', 'genap', 1, atau 2
            $semesterValue = strtolower($semester->semester ?? '');
            $isGanjil = ($semesterValue == 'ganjil' || $semesterValue == '1' || $semesterValue == 1);
            $semesterLabel = $isGanjil ? 'Ganjil' : 'Genap';
            $semesterNum = $isGanjil ? '1 (satu)' : '2 (dua)';

            // Determine kelas level dan fase berdasarkan index
            $kelasLevel = '';
            $fase = '';
            if($index < 2) {
                $kelasLevel = '10';
                $fase = 'E';  // Fase E untuk kelas 10
            } elseif($index < 4) {
                $kelasLevel = '11';
                $fase = 'F';  // Fase F untuk kelas 11
            } else {
                $kelasLevel = '12';
                $fase = 'F';  // Fase F untuk kelas 12
            }
        @endphp

        {{-- HEADER --}}
        <div class="header-title">
            LAPORAN HASIL CAPAIAN PEMBELAJARAN<br>
            KURIKULUM MERDEKA SEKOLAH MENENGAH KEJURUAN (SMK)
        </div>

        {{-- INFO SECTION --}}
        <table class="info-table">
            <tr>
                <td style="width: 25%;"><strong>Nama Peserta Didik</strong></td>
                <td style="width: 2%;">:</td>
                <td style="width: 40%;">{{ $student->nama }}</td>
                <td style="width: 15%;"><strong>Kelas</strong></td>
                <td style="width: 2%;">:</td>
                <td>{{ $kelasLevel }}</td>
            </tr>
            <tr>
                <td><strong>NISN/ NIS</strong></td>
                <td>:</td>
                <td>{{ $student->nisn ?? '-' }} / {{ $student->nis ?? '-' }}</td>
                <td><strong>Fase</strong></td>
                <td>:</td>
                <td>{{ $fase }}</td>
            </tr>
            <tr>
                <td><strong>Nama Sekolah</strong></td>
                <td>:</td>
                <td>{{ $school->nama_sekolah ?? $school->nama ?? 'SMK Muhammadiyah Plus Tanjung Selor' }}</td>
                <td><strong>Semester</strong></td>
                <td>:</td>
                <td>{{ $semesterNum }} / {{ $semesterLabel }}</td>
            </tr>
            <tr>
                <td><strong>Alamat</strong></td>
                <td>:</td>
                <td>{{ $school->alamat_jalan ?? $school->alamat ?? 'Jl. Sengkawit Gg. Padaidi RT 052' }}</td>
                <td><strong>Tahun Pelajaran</strong></td>
                <td>:</td>
                <td>{{ $semester->tahun_ajaran ?? '' }}</td>
            </tr>
        </table>

        {{-- A. INTRAKURIKULER --}}
        <div class="section-title">A. INTRAKURIKULER</div>
        <table style="font-size: 9px;">
            <thead>
                <tr>
                    <th style="width: 5%;">NO</th>
                    <th style="width: 35%;">MATA PELAJARAN</th>
                    <th style="width: 10%;">NILAI<br>AKHIR</th>
                    <th>CAPAIAN KOMPETENSI<br>(DESKRIPSI)</th>
                </tr>
            </thead>
            <tbody>
                @if($data['subjects']->count() > 0)
                    @foreach($data['subjects'] as $idx => $subject)
                        <tr>
                            <td class="center">{{ $idx + 1 }}.</td>
                            <td>{{ $subject['name'] }}</td>
                            <td class="center">{{ $subject['nilai'] }}</td>
                            <td style="font-size: 8px;">{{ $subject['deskripsi'] }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" class="center"><strong>Jumlah Nilai</strong></td>
                        <td class="center"><strong>{{ $data['subjects']->sum('nilai') }}</strong></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="center"><strong>Rata-rata</strong></td>
                        <td class="center"><strong>{{ $data['subjects']->count() > 0 ? round($data['subjects']->sum('nilai') / $data['subjects']->count()) : 0 }}</strong></td>
                        <td></td>
                    </tr>
                @else
                    <tr>
                        <td colspan="2" class="center">Jumlah Nilai</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="center">Rata-rata</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
            </tbody>
        </table>

        {{-- B. PROJEK PENGUATAN PROFIL PELAJAR PANCASILA --}}
        <div class="section-title">B. PROJEK PENGUATAN PROFIL PELAJAR PANCASILA</div>
        <table style="font-size: 9px;">
            <thead>
                <tr>
                    <th style="width: 5%;">NO</th>
                    <th style="width: 30%;">DIMENSI</th>
                    <th style="width: 50%;">ELEMEN CAPAIAN KOMPETENSI</th>
                    <th style="width: 15%;">NILAI</th>
                </tr>
            </thead>
            <tbody>
                @if(count($data['p5']) > 0)
                    @foreach($data['p5'] as $idx => $p5)
                        <tr>
                            <td class="center">{{ $idx + 1 }}</td>
                            <td>{{ $p5['dimension'] }}</td>
                            <td style="font-size: 8px;">{{ $p5['element'] }}</td>
                            <td class="center">{{ $p5['nilai'] }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="center">-</td>
                        <td>-</td>
                        <td>-</td>
                        <td class="center">-</td>
                    </tr>
                @endif
            </tbody>
        </table>

        {{-- C. EKSTRAKURIKULER --}}
        <div class="section-title">C. EKSTRAKURIKULER</div>
        <table style="font-size: 9px;">
            <thead>
                <tr>
                    <th style="width: 5%;">NO</th>
                    <th style="width: 35%;">KEGIATAN EKSTRAKURIKULER</th>
                    <th style="width: 45%;">KETERANGAN</th>
                    <th style="width: 15%;">NILAI</th>
                </tr>
            </thead>
            <tbody>
                @if($data['ekstrakurikuler']->count() > 0)
                    @foreach($data['ekstrakurikuler'] as $idx => $ekskul)
                        <tr>
                            <td class="center">{{ $idx + 1 }}.</td>
                            <td>{{ $ekskul['name'] }}</td>
                            <td style="font-size: 8px;">{{ $ekskul['keterangan'] }}</td>
                            <td class="center">{{ $ekskul['nilai'] }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="center">-</td>
                        <td>-</td>
                        <td>-</td>
                        <td class="center">-</td>
                    </tr>
                @endif
            </tbody>
        </table>

        {{-- KETIDAKHADIRAN & KENAIKAN/KEPUTUSAN --}}
        @if($semester->semester == 2)
            {{-- Semester Genap - Include Kenaikan section --}}
            <table class="no-border" style="margin-top: 10px; font-size: 9px;">
                <tr>
                    <td style="width: 50%; vertical-align: top; padding-right: 10px;">
                        <table style="width: 100%; border: 1px solid #000;">
                            <tr>
                                <td colspan="2" class="fw700" style="background: #f0f0f0;">KETIDAKHADIRAN</td>
                            </tr>
                            <tr>
                                <td style="width: 70%; border-top: 1px solid #000;">1. Sakit</td>
                                <td style="border-top: 1px solid #000; border-left: 1px solid #000;">{{ $data['kehadiran']['sakit'] }} Hari</td>
                            </tr>
                            <tr>
                                <td style="border-top: 1px solid #000;">2. Izin</td>
                                <td style="border-top: 1px solid #000; border-left: 1px solid #000;">{{ $data['kehadiran']['izin'] }} Hari</td>
                            </tr>
                            <tr>
                                <td style="border-top: 1px solid #000;">3. Tanpa Keterangan</td>
                                <td style="border-top: 1px solid #000; border-left: 1px solid #000;">{{ $data['kehadiran']['alpha'] }} Hari</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 50%; vertical-align: top;">
                        <table style="width: 100%; border: 1px solid #000;">
                            <tr>
                                <td rowspan="3" class="fw700" style="background: #f0f0f0; width: 30%;">KENAIKAN</td>
                                <td colspan="2" style="border-left: 1px solid #000; font-size: 8px;">
                                    <strong>Keputusan :</strong><br>
                                    Berdasarkan capaian pembelajaran pada semester 1 dan 2 peserta didik ditetapkan
                                </td>
                            </tr>
                            <tr>
                                <td style="border-top: 1px solid #000; border-left: 1px solid #000; width: 40%;"><strong>Naik/Tidak Naik</strong></td>
                                <td style="border-top: 1px solid #000; border-left: 1px solid #000;">
                                    <strong>Mengetahui<br>Kepala Sekolah</strong>
                                </td>
                            </tr>
                            <tr>
                                <td style="border-top: 1px solid #000; border-left: 1px solid #000;">
                                    Ke Kelas : {{ $data['promotion']->next_class ?? '' }}<br>
                                    Tanggal :
                                </td>
                                <td style="border-top: 1px solid #000; border-left: 1px solid #000; text-align: center; padding-top: 30px;">
                                    <strong>{{ $kepalaSekolah->nama ?? 'Nurhayati Ambo' }}</strong><br>
                                    NIP. {{ $kepalaSekolah->nip ?? '-' }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right; padding-top: 10px;">
                        <strong>Wali Kelas</strong><br><br><br>
                        <strong>{{ $waliKelas->nama ?? 'Rofik Angtiangsih, S.Pd.I' }}</strong><br>
                        NIP. {{ $waliKelas->nip ?? '-' }}
                    </td>
                </tr>
            </table>
        @else
            {{-- Semester Ganjil - Only Ketidakhadiran --}}
            <table style="margin-top: 10px; font-size: 9px; width: 50%;">
                <tr>
                    <td colspan="2" class="fw700 center">KETIDAKHADIRAN</td>
                </tr>
                <tr>
                    <td style="width: 70%;">1. Sakit</td>
                    <td>{{ $data['kehadiran']['sakit'] }} Hari</td>
                </tr>
                <tr>
                    <td>2. Izin</td>
                    <td>{{ $data['kehadiran']['izin'] }} Hari</td>
                </tr>
                <tr>
                    <td>3. Tanpa Keterangan</td>
                    <td>{{ $data['kehadiran']['alpha'] }} Hari</td>
                </tr>
            </table>

            <table class="no-border" style="margin-top: 30px; font-size: 10px;">
                <tr>
                    <td style="width: 50%; text-align: center;">
                        <strong>Wali Kelas</strong>
                        <br><br><br><br><br>
                        <strong>{{ $waliKelas->nama ?? 'Rofik Angtiangsih, S.Pd.I' }}</strong><br>
                        NIP. {{ $waliKelas->nip ?? '-' }}
                    </td>
                    <td style="width: 50%; text-align: center;">
                        <strong>Mengetahui<br>Kepala Sekolah</strong>
                        <br><br><br><br>
                        <strong>{{ $kepalaSekolah->nama ?? 'Nurhayati Ambo' }}</strong><br>
                        NIP. {{ $kepalaSekolah->nip ?? '-' }}
                    </td>
                </tr>
            </table>
        @endif

    @endforeach

    {{-- HALAMAN AKHIR: REKAPITULASI --}}
    @if(count($allSemesters) > 0)
        <div class="page-break"></div>

        <div class="header-title">
            LAPORAN HASIL AKHIR CAPAIAN PEMBELAJARAN PESERTA DIDIK<br>
            KURIKULUM MERDEKA SEKOLAH MENENGAH KEJURUAN (SMK)
        </div>

        {{-- INFO SECTION --}}
        <table class="info-table">
            <tr>
                <td style="width: 25%;"><strong>Nama Peserta Didik</strong></td>
                <td style="width: 2%;">:</td>
                <td style="width: 40%;">{{ $student->nama }}</td>
                <td style="width: 15%;"><strong>Kelas</strong></td>
                <td style="width: 2%;">:</td>
                <td>12</td>
            </tr>
            <tr>
                <td><strong>NISN/ NIS</strong></td>
                <td>:</td>
                <td>{{ $student->nisn ?? '-' }} / {{ $student->nis ?? '-' }}</td>
                <td><strong>Fase</strong></td>
                <td>:</td>
                <td>F</td>
            </tr>
            <tr>
                <td><strong>Nama Sekolah</strong></td>
                <td>:</td>
                <td>{{ $school->nama_sekolah ?? $school->nama ?? 'SMK Muhammadiyah Plus Tanjung Selor' }}</td>
                <td><strong>Semester</strong></td>
                <td>:</td>
                <td>2 (dua) / Genap</td>
            </tr>
            <tr>
                <td><strong>Alamat</strong></td>
                <td>:</td>
                <td>{{ $school->alamat_jalan ?? $school->alamat ?? 'Jl. Sengkawit Gg. Padaidi RT 052' }}</td>
                <td><strong>Tahun Pelajaran</strong></td>
                <td>:</td>
                <td></td>
            </tr>
        </table>

        {{-- A. INTRAKURIKULER - REKAPITULASI --}}
        <div class="section-title">A. INTRAKURIKULER</div>
        <table style="font-size: 8px;">
            <thead>
                <tr>
                    <th rowspan="2" style="width: 5%;">NO</th>
                    <th rowspan="2" style="width: 30%;">MATA PELAJARAN</th>
                    <th colspan="3">Kelas 10</th>
                    <th colspan="3">Kelas 11</th>
                    <th colspan="3">Kelas 12</th>
                </tr>
                <tr>
                    <th style="width: 7%;">Sem<br>Ganjil</th>
                    <th style="width: 7%;">Sem<br>Genap</th>
                    <th style="width: 7%;">Rata-<br>rata</th>
                    <th style="width: 7%;">Sem<br>Ganjil</th>
                    <th style="width: 7%;">Sem<br>Genap</th>
                    <th style="width: 7%;">Rata-<br>rata</th>
                    <th style="width: 7%;">Sem<br>Ganjil</th>
                    <th style="width: 7%;">Sem<br>Genap</th>
                    <th style="width: 7%;">Rata-<br>rata</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Collect all unique subjects
                    $allSubjects = [];
                    foreach($allSemesters as $data) {
                        foreach($data['subjects'] as $subject) {
                            $allSubjects[$subject['name']] = true;
                        }
                    }
                    $subjectNames = array_keys($allSubjects);
                @endphp

                @foreach($subjectNames as $idx => $subjectName)
                    <tr>
                        <td class="center">{{ $idx + 1 }}</td>
                        <td>{{ $subjectName }}</td>
                        @php
                            // Get scores for each semester
                            $scores = [];
                            for($i = 0; $i < 6; $i++) {
                                $score = '';
                                if(isset($allSemesters[$i])) {
                                    foreach($allSemesters[$i]['subjects'] as $subj) {
                                        if($subj['name'] == $subjectName) {
                                            $score = $subj['nilai'];
                                            break;
                                        }
                                    }
                                }
                                $scores[] = $score;
                            }

                            // Calculate averages
                            $avg10 = ($scores[0] && $scores[1]) ? round(($scores[0] + $scores[1]) / 2) : '';
                            $avg11 = ($scores[2] && $scores[3]) ? round(($scores[2] + $scores[3]) / 2) : '';
                            $avg12 = ($scores[4] && $scores[5]) ? round(($scores[4] + $scores[5]) / 2) : '';
                        @endphp
                        <td class="center">{{ $scores[0] }}</td>
                        <td class="center">{{ $scores[1] }}</td>
                        <td class="center">{{ $avg10 }}</td>
                        <td class="center">{{ $scores[2] }}</td>
                        <td class="center">{{ $scores[3] }}</td>
                        <td class="center">{{ $avg11 }}</td>
                        <td class="center">{{ $scores[4] }}</td>
                        <td class="center">{{ $scores[5] }}</td>
                        <td class="center">{{ $avg12 }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2" class="center"><strong>Jumlah Nilai</strong></td>
                    @for($i = 0; $i < 6; $i++)
                        @php
                            $total = 0;
                            if(isset($allSemesters[$i])) {
                                $total = $allSemesters[$i]['subjects']->sum('nilai');
                            }
                        @endphp
                        <td class="center">{{ $total ?: '' }}</td>
                        @if(($i + 1) % 2 == 0)
                            <td></td>
                        @endif
                    @endfor
                </tr>
            </tbody>
        </table>

        {{-- B. KETIDAKHADIRAN DAN KELULUSAN --}}
        <div class="section-title">B. KETIDAKHADIRAN DAN KELULUSAN</div>
        @php
            $totalSakit = 0;
            $totalIzin = 0;
            $totalAlpha = 0;
            foreach($allSemesters as $data) {
                $totalSakit += $data['kehadiran']['sakit'];
                $totalIzin += $data['kehadiran']['izin'];
                $totalAlpha += $data['kehadiran']['alpha'];
            }
        @endphp
        <table class="no-border" style="font-size: 9px;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <table style="width: 100%; border: 1px solid #000;">
                        <tr>
                            <td rowspan="3" class="fw700" style="width: 40%; background: #f0f0f0;">KETIDAKHADIRAN</td>
                            <td style="border-left: 1px solid #000;">Sakit</td>
                            <td style="border-left: 1px solid #000;">{{ $totalSakit }} Hari</td>
                        </tr>
                        <tr>
                            <td style="border-top: 1px solid #000; border-left: 1px solid #000;">Izin</td>
                            <td style="border-top: 1px solid #000; border-left: 1px solid #000;">{{ $totalIzin }} Hari</td>
                        </tr>
                        <tr>
                            <td style="border-top: 1px solid #000; border-left: 1px solid #000;">Tanpa Keterangan</td>
                            <td style="border-top: 1px solid #000; border-left: 1px solid #000;">{{ $totalAlpha }} Hari</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="fw700 center" style="border-top: 1px solid #000; background: #f0f0f0;">STATUS AKHIR</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="center fw700" style="border-top: 1px solid #000; padding: 30px 0;">LULUS / TIDAK LULUS</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="border-top: 1px solid #000; font-size: 8px;">Tanggal : .....................................</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top; padding-left: 20px;">
                    <strong>Keputusan:</strong><br>
                    Berdasarkan Hasil Belajar yang dicapai Peserta Didik ditetapkan: <strong>LULUS / TIDAK LULUS</strong>
                    <br><br>
                    No. Ijazah : ..................................<br>
                    No. SKHUS : ..................................<br>
                    Tgl / Bln / Thn : .......... /.......... /..........<br>
                    <br><br>
                    <table class="no-border" style="width: 100%;">
                        <tr>
                            <td style="width: 50%; text-align: center;">
                                <strong>Wali Kelas</strong>
                                <br><br><br><br>
                                <strong>{{ $waliKelas->nama ?? 'Rofik Angtiangsih, S.Pd.I' }}</strong><br>
                                NIP. {{ $waliKelas->nip ?? '-' }}
                            </td>
                            <td style="width: 50%; text-align: center;">
                                <strong>Mengetahui<br>Kepala Sekolah</strong>
                                <br><br><br><br>
                                <strong>{{ $kepalaSekolah->nama ?? 'Nurhayati Ambo' }}</strong><br>
                                NIP. {{ $kepalaSekolah->nip ?? '-' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    @endif

</body>

</html>
