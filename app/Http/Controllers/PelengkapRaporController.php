<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\School;
use App\Models\SchoolHead;
use App\Models\ReportDate;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Carbon\Carbon;

class PelengkapRaporController extends Controller
{

    public function pdf(Request $request, $studentId)
{
    $student = Student::with(['class','school'])->findOrFail($studentId);
    $school  = School::first();

    // Kepala sekolah (dari table school_heads bila ada)
    $head = SchoolHead::where('school_id', $school->id)->first();
    $kepsekNama = $head->nama_lengkap ?? ($school->kepala_sekolah ?? null);
    $kepsekNip  = $head->nip ?? ($school->nip_kepala ?? null);

    // === Report dates ===
    $report = ReportDate::where('class_id', $student->class_id)
        ->when($request->integer('semester_id'), fn($q,$sid) => $q->where('semester_id', $sid))
        ->latest('id')
        ->first();

    $reportMidDate   = $report && $report->mid_report_date
        ? Carbon::parse($report->mid_report_date)->format('d F Y') : null;
    $reportFinalDate = $report && $report->final_report_date
        ? Carbon::parse($report->final_report_date)->format('d F Y') : null;

    // Tentukan tanggal tanda tangan: ?mid=1 => mid, else final
    $useMid   = (string)$request->query('mid', '0') === '1';
    $signDate = $useMid ? ($reportMidDate ?? now()->format('d F Y'))
                        : ($reportFinalDate ?? now()->format('d F Y'));

    $kompetensi = $student->class->jurusan
        ?? optional($student->class)->nama_kelas
        ?? '-';


    $pdf = PDF::loadView('rapor.pelengkap', [
            'student'         => $student,
            'school'          => $school,
            'kompetensi'      => $kompetensi,
            'kepsekNama'      => $kepsekNama,
            'kepsekNip'       => $kepsekNip,
            // kirim tanggal rapor
            'reportMidDate'   => $reportMidDate,
            'reportFinalDate' => $reportFinalDate,
            'signDate'        => $signDate,
        ])
        ->setOption('page-width', '210mm')
        ->setOption('page-height', '330mm')
        ->setOption('margin-top', '12mm')
        ->setOption('margin-right', '12mm')
        ->setOption('margin-bottom', '12mm')
        ->setOption('margin-left', '12mm')
        ->setOption('encoding', 'utf-8')
        ->setOption('print-media-type', true)
        ->setOption('disable-smart-shrinking', true)
        ->setOption('enable-local-file-access', true)
        ->setOption('dpi', 96);

    return $pdf->inline('Pelengkap_Rapor_'.$student->nama.'.pdf');
}

}
