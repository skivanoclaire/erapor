<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    ClassSubject, SubjectEnrollment, Student, FinalGrade, Assessment, AssessmentScore
};
use Illuminate\Support\Facades\DB;

class FinalGradeController extends Controller
{
    public function edit(Request $r, ClassSubject $cs)
    {
        // Ambil siswa dari subject_enrollments (yang ikut mapel ini)
        $enrolledIds = SubjectEnrollment::where('semester_id', $cs->semester_id)
            ->where('class_id', $cs->class_id)
            ->where('class_subject_id', $cs->id)
            ->where('participates', 1)
            ->pluck('student_id');

        // Jika belum ada enroll, fallback ke semua siswa kelas
        $students = $enrolledIds->isNotEmpty()
            ? Student::whereIn('id', $enrolledIds)->orderBy('nama')->get()
            : Student::where('class_id', $cs->class_id)->orderBy('nama')->get();

        // Map nilai akhir yang sudah ada
        $existing = FinalGrade::where('class_subject_id', $cs->id)
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->keyBy('student_id');

        return view('final_grades.edit', compact('cs','students','existing'));
    }

    public function update(Request $r, ClassSubject $cs)
    {
        $data = $r->validate([
            'scores'   => ['array'],
            'scores.*' => ['nullable','numeric','min:0','max:1000'],
        ]);

        DB::transaction(function () use ($data, $cs) {
            $now = now();
            foreach ($data['scores'] ?? [] as $studentId => $val) {
                if ($val === null || $val === '') {
                    // kosongkan jika dihapus
                    FinalGrade::where([
                        'class_subject_id'=>$cs->id,
                        'student_id'=>$studentId,
                    ])->delete();
                    continue;
                }

                FinalGrade::updateOrCreate(
                    ['class_subject_id'=>$cs->id,'student_id'=>$studentId],
                    ['final_score'=>$val,'computed_at'=>$now]
                );
            }
        });

        return back()->with('ok','Nilai akhir disimpan.');
    }

    // OPSIONAL: Hitung otomatis dari penilaian (assessments + assessment_scores)
    public function recompute(ClassSubject $cs)
    {
        // Ambil semua penilaian mapel ini
        $assessments = Assessment::where('class_subject_id', $cs->id)->get();

        if ($assessments->isEmpty()) {
            return back()->with('err','Belum ada penilaian pada mapel ini.');
        }

        // Bobot default 1.0; normalisasi bobot total
        $grouped = $assessments->groupBy('id');
        $weights = $assessments->pluck('weight','id');
        $maxes   = $assessments->pluck('max_score','id');

        // Ambil semua skor siswa untuk penilaian-penilaian tersebut
        $scores = AssessmentScore::whereIn('assessment_id', $assessments->pluck('id'))
            ->get()
            ->groupBy('student_id');

        DB::transaction(function () use ($scores, $weights, $maxes, $cs) {
            $now = now();
            foreach ($scores as $studentId => $rows) {
                $num = 0.0; $den = 0.0;
                foreach ($rows as $row) {
                    $score = $row->score;
                    if ($score === null) continue;

                    $aid  = $row->assessment_id;
                    $w    = (float) ($weights[$aid] ?? 1);
                    $max  = (float) max(1, ($maxes[$aid] ?? 100));

                    // skala ke 0..100 lalu *weight
                    $num += ($score / $max) * 100.0 * $w;
                    $den += $w;
                }
                if ($den <= 0) continue;

                $final = round($num / $den, 2);

                FinalGrade::updateOrCreate(
                    ['class_subject_id'=>$cs->id, 'student_id'=>$studentId],
                    ['final_score'=>$final, 'computed_at'=>$now]
                );
            }
        });

        return back()->with('ok','Nilai akhir dihitung dari penilaian.');
    }
}
