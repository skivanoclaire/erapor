<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{
    ClassSubject, Assessment, AssessmentScore, SubjectEnrollment,
    Student, FinalGrade, AssessmentTechnique
};

class AssessmentBoardController extends Controller
{
    /** Papan penilaian (grid F/S/AS + NA + AKHIR) */
    public function board(ClassSubject $cs, Request $r)
    {
        // daftar siswa: prioritaskan yg ter-enroll pada mapel ini
        $enrolledIds = SubjectEnrollment::where([
            'semester_id'=>$cs->semester_id,
            'class_id'=>$cs->class_id,
            'class_subject_id'=>$cs->id,
            'participates'=>1,
        ])->pluck('student_id');

        $students = $enrolledIds->isNotEmpty()
            ? Student::whereIn('id',$enrolledIds)->orderBy('nama')->get()
            : Student::where('class_id',$cs->class_id)->orderBy('nama')->get();

        // semua penilaian mapel ini
        $assessments = Assessment::where('class_subject_id',$cs->id)
            ->orderBy('type')
            ->orderBy('date')
            ->orderBy('id')
            ->get();

        // group by type untuk header
        $groups = [
            'formatif'   => $assessments->where('type','formatif')->values(),
            'sumatif'    => $assessments->where('type','sumatif')->values(),
            'sumatif_as' => $assessments->where('type','sumatif_as')->values(),
        ];

        // skor existing -> map [assessment_id][student_id] = score
        $scoreRows = AssessmentScore::whereIn('assessment_id',$assessments->pluck('id'))->get();
        $scores = [];
        foreach ($scoreRows as $row) {
            $scores[$row->assessment_id][$row->student_id] = $row->score;
        }

        // teknik penilaian (dropdown)
        $techniques = AssessmentTechnique::where('school_id',$cs->school_id)
            ->orderBy('short_name')->get();

        return view('assessments.board', compact('cs','students','groups','assessments','scores','techniques'));
    }

    /** Tambah penilaian */
    public function storeAssessment(Request $r, ClassSubject $cs)
    {
        $data = $r->validate([
            'type'        => ['required','in:formatif,sumatif,sumatif_as'],
            'technique_id'=> ['nullable','exists:assessment_techniques,id'],
            'title'       => ['required','string','max:150'],
            'date'        => ['nullable','date'],
            'max_score'   => ['required','numeric','min:1','max:10000'],
            'weight'      => ['required','numeric','min:0.01','max:100'],
        ]);
        $data['class_subject_id'] = $cs->id;

        Assessment::create($data);
        return back()->with('ok','Penilaian dibuat.');
    }

    /** Ubah atribut penilaian (bobot, judul, dll) */
    public function updateAssessment(Request $r, Assessment $asmt)
    {
        $data = $r->validate([
            'type'        => ['required','in:formatif,sumatif,sumatif_as'],
            'technique_id'=> ['nullable','exists:assessment_techniques,id'],
            'title'       => ['required','string','max:150'],
            'date'        => ['nullable','date'],
            'max_score'   => ['required','numeric','min:1','max:10000'],
            'weight'      => ['required','numeric','min:0.01','max:100'],
        ]);
        $asmt->update($data);

        // tidak wajib recompute di sini (nilai belum berubah), tapi aman kita lakukan
        $this->recomputeFinalCore($asmt->class_subject_id);
        return back()->with('ok','Penilaian diperbarui.');
    }

    /** Hapus penilaian beserta skor, lalu recompute final */
    public function destroyAssessment(Assessment $asmt)
    {
        $csId = $asmt->class_subject_id;

        DB::transaction(function() use ($asmt, $csId){
            AssessmentScore::where('assessment_id',$asmt->id)->delete();
            $asmt->delete();
            $this->recomputeFinalCore($csId);
        });

        return back()->with('ok','Penilaian dihapus.');
    }

    /** Simpan skor grid + recompute final */
    public function saveScores(Request $r, ClassSubject $cs)
    {
        $data = $r->validate([
            'scores'            => ['array'],
            'scores.*.*'        => ['nullable','numeric','min:0','max:10000'], // scores[assessment_id][student_id]
        ]);

        DB::transaction(function () use ($data, $cs) {
            foreach (($data['scores'] ?? []) as $asmtId => $byStudent) {
                foreach ($byStudent as $studentId => $val) {
                    if ($val === null || $val === '') {
                        AssessmentScore::where([
                            'assessment_id'=>$asmtId,
                            'student_id'=>$studentId
                        ])->delete();
                    } else {
                        AssessmentScore::updateOrCreate(
                            ['assessment_id'=>$asmtId,'student_id'=>$studentId],
                            ['score'=>$val]
                        );
                    }
                }
            }
            $this->recomputeFinalCore($cs->id);
        });

        return back()->with('ok','Skor disimpan & nilai akhir direkap.');
    }

    /** Rekap ulang manual (opsional tombol) */
    public function recomputeFinal(ClassSubject $cs)
    {
        $this->recomputeFinalCore($cs->id);
        return back()->with('ok','Nilai akhir direkap ulang.');
    }

    /** Algoritma rekap final: normalisasi skor (0..100) lalu rata tertimbang (weight) */
    private function recomputeFinalCore(int $classSubjectId): void
    {
        $asmts = Assessment::where('class_subject_id',$classSubjectId)->get();
        if ($asmts->isEmpty()) {
            FinalGrade::where('class_subject_id',$classSubjectId)->delete();
            return;
        }

        $weights = $asmts->pluck('weight','id');
        $maxes   = $asmts->pluck('max_score','id');

        $scores = AssessmentScore::whereIn('assessment_id',$asmts->pluck('id'))
            ->get()
            ->groupBy('student_id');

        DB::transaction(function() use ($scores,$weights,$maxes,$classSubjectId){
            $now = now();
            foreach ($scores as $studentId => $rows) {
                $num=0.0; $den=0.0;
                foreach ($rows as $row) {
                    if ($row->score === null) continue;
                    $aid = $row->assessment_id;
                    $w   = (float) ($weights[$aid] ?? 1);
                    $max = (float) max(1, ($maxes[$aid] ?? 100));
                    $num += ($row->score / $max) * 100.0 * $w;
                    $den += $w;
                }
                if ($den <= 0) continue;
                $final = round($num / $den, 2);

                FinalGrade::updateOrCreate(
                    ['class_subject_id'=>$classSubjectId,'student_id'=>$studentId],
                    ['final_score'=>$final,'computed_at'=>$now]
                );
            }
        });
    }
}
