<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Semester;
use App\Models\ClassSchedule;
use App\Models\FinalGrade;
use App\Models\Attendance;
use App\Models\ExtracurricularAssessment;
use App\Models\P5Project;
use App\Models\P5ProjectRating;
use App\Models\Promotion;
use PDF;

class BookReportController extends Controller
{
    public function show(Student $student)
    {
        $data = $this->prepareData($student);
        return view('rapor.buku_induk', $data);
    }

    public function pdf(Student $student)
    {
        $data = $this->prepareData($student);

        $html = view('rapor.buku_induk', $data)->render();

        return PDF::loadHTML($html)
            ->setOption('page-width', '210mm')
            ->setOption('page-height', '330mm')
            ->setOption('margin-top', '12mm')
            ->setOption('margin-bottom', '12mm')
            ->setOption('margin-left', '12mm')
            ->setOption('margin-right', '12mm')
            ->inline('Buku_Induk_'.$student->nama.'.pdf');
    }

    private function prepareData(Student $student)
    {
        // Data sekolah
        $school = \App\Models\School::first();

        // Class info
        $class = $student->class()->with(['wali'])->first();

        // Wali kelas dengan gelar lengkap
        $wali = $class->wali ?? null;
        $waliKelas = (object)[
            'nama' => $wali ? trim(($wali->gelar_depan ? $wali->gelar_depan.' ' : '').$wali->nama.(!empty($wali->gelar_belakang) ? ', '.$wali->gelar_belakang : '')) : null,
            'nip' => $wali->nip ?? null,
        ];

        // Kepala sekolah dengan gelar lengkap
        $kepsek = \App\Models\User::where('jenis_ptk', 'kepala_sekolah')->first();
        $kepalaSekolah = (object)[
            'nama' => $kepsek ? trim(($kepsek->gelar_depan ? $kepsek->gelar_depan.' ' : '').$kepsek->nama.(!empty($kepsek->gelar_belakang) ? ', '.$kepsek->gelar_belakang : '')) : null,
            'nip' => $kepsek->nip ?? null,
        ];

        // Buat 6 semester placeholder (10 Ganjil, 10 Genap, 11 Ganjil, 11 Genap, 12 Ganjil, 12 Genap)
        $semesterData = [];

        // Ambil semua semester yang ada di database
        $existingSemesters = Semester::orderBy('tahun_ajaran')->orderBy('semester')->get();

        // Array untuk 6 semester dengan tahun ajaran yang berbeda
        $semesterStructure = [
            ['kelas' => 10, 'semester' => 'ganjil', 'index' => 0],
            ['kelas' => 10, 'semester' => 'genap', 'index' => 1],
            ['kelas' => 11, 'semester' => 'ganjil', 'index' => 2],
            ['kelas' => 11, 'semester' => 'genap', 'index' => 3],
            ['kelas' => 12, 'semester' => 'ganjil', 'index' => 4],
            ['kelas' => 12, 'semester' => 'genap', 'index' => 5],
        ];

        foreach ($semesterStructure as $structure) {
            // Cari semester yang cocok dari database, atau buat placeholder
            $semester = $existingSemesters->get($structure['index']) ?? (object)[
                'id' => null,
                'tahun_ajaran' => '',
                'semester' => $structure['semester'],
            ];

            // Hanya ambil data jika semester ada di database
            if ($semester->id) {
                // Nilai intrakurikuler
                $grades = FinalGrade::where('final_grades.student_id', $student->id)
                    ->join('class_subjects', 'final_grades.class_subject_id', '=', 'class_subjects.id')
                    ->where('class_subjects.semester_id', $semester->id)
                    ->with('classSubject.subject')
                    ->select('final_grades.*')
                    ->get();

                $subjects = $grades->map(function ($fg) {
                    return [
                        'name' => $fg->classSubject->subject->name ?? '-',
                        'nilai' => $fg->final_score ?? 0,
                        'deskripsi' => $fg->description ?? '',
                    ];
                });

                // P5 Projects
                $p5Data = [];
                $p5Projects = P5Project::where('semester_id', $semester->id)->get();

                foreach ($p5Projects as $project) {
                    $ratings = P5ProjectRating::where('p5_project_id', $project->id)
                        ->where('student_id', $student->id)
                        ->with('criterion')
                        ->get();

                    // Group by dimension
                    $ratingsByDimension = [1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => []];

                    foreach ($ratings as $rating) {
                        if ($rating->criterion && $rating->level && $rating->level !== '-') {
                            $dimId = $rating->criterion->dimension_id;
                            if ($dimId >= 1 && $dimId <= 6) {
                                $ratingsByDimension[$dimId][] = $rating->level;
                            }
                        }
                    }

                    $dimensions = [
                        1 => 'Beriman, Bertakwa Kepada Tuhan Yang Maha Esa, dan Berahlak Mulia',
                        2 => 'Bernalar Kritis',
                        3 => 'Mandiri',
                        4 => 'Berkebinekaan Global',
                        5 => 'Kreatif',
                        6 => 'Bergotong Royong',
                    ];

                    foreach ($ratingsByDimension as $dimId => $levels) {
                        $dominantLevel = $this->getDominantLevel($levels);
                        if ($dominantLevel) {
                            $p5Data[] = [
                                'dimension' => $dimensions[$dimId],
                                'element' => $this->getElementName($dimId, $ratings),
                                'capaian' => $this->getCapaianText($dimId, $ratings),
                                'nilai' => $dominantLevel,
                            ];
                        }
                    }
                }

                // Ekstrakurikuler
                $ekstrakurikuler = ExtracurricularAssessment::where('student_id', $student->id)
                    ->where('semester_id', $semester->id)
                    ->with('extracurricular')
                    ->get()
                    ->map(function ($assessment) {
                        return [
                            'name' => $assessment->extracurricular->name ?? '-',
                            'keterangan' => $assessment->final_description ?? '-',
                            'nilai' => $assessment->final_grade ?? '-',
                        ];
                    });

                // Attendance
                $attendance = Attendance::where('student_id', $student->id)
                    ->where('semester_id', $semester->id)
                    ->first();

                $kehadiran = [
                    'sakit' => $attendance->sakit ?? 0,
                    'izin' => $attendance->izin ?? 0,
                    'alpha' => $attendance->alpa ?? 0,
                ];

                // Promotion/Kelulusan
                $promotion = Promotion::where('student_id', $student->id)
                    ->where('semester_id', $semester->id)
                    ->first();
            } else {
                // Data kosong untuk semester yang belum ada
                $subjects = collect([]);
                $p5Data = [];
                $ekstrakurikuler = collect([]);
                $kehadiran = ['sakit' => 0, 'izin' => 0, 'alpha' => 0];
                $promotion = null;
            }

            $semesterData[] = [
                'semester' => $semester,
                'subjects' => $subjects,
                'p5' => $p5Data,
                'ekstrakurikuler' => $ekstrakurikuler,
                'kehadiran' => $kehadiran,
                'promotion' => $promotion,
            ];
        }

        return compact('student', 'school', 'class', 'waliKelas', 'kepalaSekolah', 'semesterData');
    }

    private function getDominantLevel(array $levels)
    {
        if (empty($levels)) return null;
        $counts = array_count_values($levels);
        $priority = ['SAB', 'BSH', 'SB', 'MB'];
        foreach ($priority as $level) {
            if (isset($counts[$level]) && $counts[$level] > 0) {
                return $level;
            }
        }
        return null;
    }

    private function getElementName($dimensionId, $ratings)
    {
        // Ambil elemen pertama dari ratings untuk dimensi ini
        foreach ($ratings as $rating) {
            if ($rating->criterion && $rating->criterion->dimension_id == $dimensionId) {
                return $rating->criterion->title ?? '-';
            }
        }
        return '-';
    }

    private function getCapaianText($dimensionId, $ratings)
    {
        // Ambil description pertama dari ratings untuk dimensi ini
        foreach ($ratings as $rating) {
            if ($rating->criterion && $rating->criterion->dimension_id == $dimensionId && $rating->description) {
                return $rating->description;
            }
        }
        return '-';
    }
}
