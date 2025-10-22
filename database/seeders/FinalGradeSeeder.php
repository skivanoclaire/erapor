<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinalGradeSeeder extends Seeder
{
    public function run(): void
    {
        // Hitung nilai akhir sederhana: rata-rata tertimbang (score * weight) / sum(weight)
        $classSubjects = DB::table('class_subjects')->pluck('id');

        foreach ($classSubjects as $csId) {
            $assessments = DB::table('assessments')->where('class_subject_id',$csId)->get(['id','weight']);
            if ($assessments->isEmpty()) continue;

            $sumWeight = $assessments->sum('weight');
            if ($sumWeight <= 0) $sumWeight = 1;

            $studentIds = DB::table('subject_enrollments')->where('class_subject_id',$csId)->pluck('student_id')->unique();
            foreach ($studentIds as $sid) {
                $weighted = 0;
                foreach ($assessments as $a) {
                    $score = DB::table('assessment_scores')
                        ->where('assessment_id',$a->id)
                        ->where('student_id',$sid)
                        ->value('score');
                    if (!is_null($score)) $weighted += (float)$score * (float)$a->weight;
                }
                $final = round($weighted / $sumWeight, 2);

                DB::table('final_grades')->updateOrInsert(
                    ['class_subject_id'=>$csId,'student_id'=>$sid],
                    ['final_score'=>$final,'computed_at'=>now(),'updated_at'=>now(),'created_at'=>now()]
                );
            }
        }
    }
}
