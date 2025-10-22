<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Semester;
use App\Models\School;
use App\Models\P5Project;
use App\Models\P5ProjectRating;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class P5ReportController extends Controller
{
    public function show(Student $student, Semester $semester)
    {
        $data = $this->loadP5Data($student, $semester);
        return view('rapor.p5', $data);
    }

    public function pdf(Student $student, Semester $semester)
    {
        $data = $this->loadP5Data($student, $semester);

        $html = view('rapor.p5', $data)->render();

        return PDF::loadHTML($html)
            ->setOption('page-width',  '210mm')
            ->setOption('page-height', '330mm')
            ->setOption('margin-top',     '12mm')
            ->setOption('margin-right',   '12mm')
            ->setOption('margin-bottom',  '12mm')
            ->setOption('margin-left',    '12mm')
            ->setOption('encoding', 'utf-8')
            ->setOption('print-media-type', true)
            ->setOption('disable-smart-shrinking', true)
            ->setOption('enable-local-file-access', true)
            ->setOption('dpi', 96)
            ->inline('P5BK_'.$student->nama.'_'.$semester->tahun_ajaran.'.pdf');
    }

    private function loadP5Data(Student $student, Semester $semester)
    {
        // 1) Kelas siswa
        $class = $student->class()->with(['wali'])->first();

        // 2) Data sekolah
        $school = School::first();

        // 3) Fase
        $fase = $class->fase ?? 'F';

        // 4) Ambil semua projek P5 untuk kelas dan semester ini
        $projects = P5Project::where('class_id', $class->id)
            ->where('semester_id', $semester->id)
            ->where('active', true)
            ->with(['criteria' => function($q) {
                $q->orderBy('order_no');
            }])
            ->get();

        // 5) Ambil ratings untuk siswa ini
        $ratings = P5ProjectRating::where('student_id', $student->id)
            ->whereIn('p5_project_id', $projects->pluck('id'))
            ->get()
            ->groupBy('p5_project_id');

        // 6) Rakit data projek dengan ratings
        $projectsData = $projects->map(function ($project) use ($ratings, $student) {
            $projectRatings = $ratings->get($project->id, collect());

            // Group ratings by criterion
            $criteriaRatings = $projectRatings->groupBy('criterion_id');

            // Map criteria dengan ratings
            $criteria = $project->criteria->map(function ($criterion) use ($criteriaRatings) {
                $rating = $criteriaRatings->get($criterion->id, collect())->first();

                return [
                    'title' => $criterion->title,
                    'dimension_id' => $criterion->dimension_id,
                    'level' => $rating ? $rating->level : null,
                    'description' => $rating ? $rating->description : null,
                ];
            });

            // 6 dimensi profil pelajar - menggunakan dimension_id dari criteria
            // Ambil semua ratings untuk projek ini
            $allRatings = P5ProjectRating::where('p5_project_id', $project->id)
                ->where('student_id', $student->id)
                ->with('criterion')
                ->get();

            // Group ratings berdasarkan dimension_id
            $ratingsByDimension = [
                1 => [], // Beriman
                2 => [], // Bernalar Kritis
                3 => [], // Mandiri
                4 => [], // Berkebinekaan
                5 => [], // Kreatif
                6 => [], // Bergotong Royong
            ];

            foreach ($allRatings as $rating) {
                if (!$rating->criterion || !$rating->level || $rating->level === '-') continue;

                // Gunakan dimension_id dari criterion
                $dimensionId = $rating->criterion->dimension_id;

                if ($dimensionId >= 1 && $dimensionId <= 6) {
                    $ratingsByDimension[$dimensionId][] = $rating->level;
                }
            }

            // Hitung level dominan per dimensi
            $dimensionLevels = [
                'beriman' => $this->getDominantLevel($ratingsByDimension[1]),
                'bernalar_kritis' => $this->getDominantLevel($ratingsByDimension[2]),
                'mandiri' => $this->getDominantLevel($ratingsByDimension[3]),
                'berkebinekaan' => $this->getDominantLevel($ratingsByDimension[4]),
                'kreatif' => $this->getDominantLevel($ratingsByDimension[5]),
                'bergotong_royong' => $this->getDominantLevel($ratingsByDimension[6]),
            ];

            // Catatan proses
            $catatan = $projectRatings->pluck('description')->filter()->first() ??
                       'Mampu mengembangkan keterampilan dalam ' . strtolower($project->theme);

            return [
                'id' => $project->id,
                'theme' => $project->theme,
                'criteria' => $criteria,
                'dimension_levels' => $dimensionLevels,
                'catatan_proses' => $catatan,
            ];
        });

        // 7) Wali kelas dan kepala sekolah dengan gelar lengkap
        $wali = $class->wali ?? null;
        $waliKelas = (object)[
            'nama' => $wali ? trim(($wali->gelar_depan ? $wali->gelar_depan.' ' : '').$wali->nama.(!empty($wali->gelar_belakang) ? ', '.$wali->gelar_belakang : '')) : null,
            'nip' => $wali->nip ?? null,
        ];

        $kepsek = \App\Models\User::where('jenis_ptk', 'kepala_sekolah')->first();
        $kepalaSekolah = (object)[
            'nama' => $kepsek ? trim(($kepsek->gelar_depan ? $kepsek->gelar_depan.' ' : '').$kepsek->nama.(!empty($kepsek->gelar_belakang) ? ', '.$kepsek->gelar_belakang : '')) : null,
            'nip' => $kepsek->nip ?? null,
        ];

        return [
            'student' => $student,
            'semester' => $semester,
            'school' => $school,
            'class' => $class,
            'fase' => $fase,
            'projects' => $projectsData,
            'waliKelas' => $waliKelas,
            'kepalaSekolah' => $kepalaSekolah,
        ];
    }

    /**
     * Menentukan level dominan dari array levels
     * Prioritas: SAB > BSH > SB > MB
     */
    private function getDominantLevel(array $levels)
    {
        if (empty($levels)) return null;

        // Hitung frekuensi setiap level
        $counts = array_count_values($levels);

        // Urutan prioritas (dari tertinggi ke terendah)
        $priority = ['SAB', 'BSH', 'SB', 'MB'];

        // Cari level dengan prioritas tertinggi yang ada
        foreach ($priority as $level) {
            if (isset($counts[$level]) && $counts[$level] > 0) {
                return $level;
            }
        }

        return null;
    }
}
