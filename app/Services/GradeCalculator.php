<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class GradeCalculator
{
    /**
     * Hitung NA per-blok (F/S/AS) untuk semua siswa dalam satu class_subject.
     * Rumus: SUM(score * weight)/SUM(weight). Abaikan nilai null.
     * Return: [student_id => nilai] (2 desimal)
     */
    public function blockNA(int $classSubjectId, string $type): array
    {
        $rows = DB::table('assessment_scores as sc')
            ->join('assessments as a', 'a.id', '=', 'sc.assessment_id')
            ->where('a.class_subject_id', $classSubjectId)
            ->where('a.type', $type) // 'formatif' | 'sumatif' | 'sumatif_as'
            ->whereNotNull('sc.score')
            ->selectRaw('sc.student_id, 
                CASE WHEN SUM(a.weight) = 0 THEN NULL
                     ELSE ROUND(SUM(sc.score * a.weight)/SUM(a.weight), 2) END as na')
            ->groupBy('sc.student_id')
            ->get();

        $na = [];
        foreach ($rows as $r) {
            $na[(int)$r->student_id] = $r->na !== null ? (float)$r->na : null;
        }
        return $na;
    }

    /**
     * Hitung & simpan final_grades untuk semua siswa pada class_subject.
     * AKHIR = (wF*NAF + wS*NAS + wAS*NAAS) / (wF + wS + wAS).
     */
    public function computeAndUpsertFinal(int $classSubjectId): void
    {
        // Ambil bobot blok dari assessment_plans
        $plan = DB::table('assessment_plans')->where('class_subject_id', $classSubjectId)->first();
        $wF = $plan->weight_formatif ?? 0.0;
        $wS = $plan->weight_sumatif ?? 1.0;
        $wAS= $plan->weight_sumatif_as ?? 1.0;

        // Hitung NA per-blok
        $naF  = $this->blockNA($classSubjectId, 'formatif');
        $naS  = $this->blockNA($classSubjectId, 'sumatif');
        $naAS = $this->blockNA($classSubjectId, 'sumatif_as');

        // Daftar siswa yang pernah punya skor di salah satu blok
        $studentIds = collect([$naF,$naS,$naAS])->flatMap(fn($m)=>array_keys($m))->unique()->values();

        $now = now();
        $payload = [];
        foreach ($studentIds as $sid) {
            $nF  = $naF[$sid]  ?? null;
            $nS  = $naS[$sid]  ?? null;
            $nAS = $naAS[$sid] ?? null;

            // Jika suatu blok tidak ada nilainya, kontribusinya 0 (dan tidak mempengaruhi pembagi jika bobot 0)
            $num = 0.0; $den = 0.0;
            if ($wF > 0 && $nF !== null)  { $num += $wF  * $nF;  $den += $wF;  }
            if ($wS > 0 && $nS !== null)  { $num += $wS  * $nS;  $den += $wS;  }
            if ($wAS> 0 && $nAS!== null)  { $num += $wAS * $nAS; $den += $wAS; }

            $final = $den > 0 ? round($num/$den, 2) : null;

            // Upsert ke final_grades
            if ($final !== null) {
                $payload[] = [
                    'class_subject_id' => $classSubjectId,
                    'student_id'       => $sid,
                    'final_score'      => $final,
                    'computed_at'      => $now,
                    'created_at'       => $now,
                    'updated_at'       => $now,
                ];
            }
        }

        if ($payload) {
            DB::table('final_grades')->upsert(
                $payload,
                ['class_subject_id','student_id'],
                ['final_score','computed_at','updated_at']
            );
        }
    }

    /**
     * Ambil rincian sumatif (maks 5) untuk keperluan cetak rapor tengah semester.
     * Return: [assessment_id => ['title'=>..., 'score'=>...]] per siswa.
     */
    public function sumatifBreakdown(int $classSubjectId, int $studentId, int $limit = 5): array
    {
        $rows = DB::table('assessments as a')
            ->leftJoin('assessment_scores as sc', function($j){
                $j->on('sc.assessment_id','=','a.id');
            })
            ->where('a.class_subject_id',$classSubjectId)
            ->where('a.type','sumatif')
            ->orderBy('a.date')
            ->orderBy('a.id')
            ->limit($limit)
            ->select('a.id','a.title','sc.score')
            ->get();

        $out = [];
        foreach ($rows as $r) {
            $out[$r->id] = ['title'=>$r->title, 'score'=>$r->score];
        }
        return $out;
    }
}
