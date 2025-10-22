<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssessmentPlanSeeder extends Seeder
{
    public function run(): void
    {
        $classSubjects = DB::table('class_subjects')->pluck('id');
        foreach ($classSubjects as $csId) {
            DB::table('assessment_plans')->upsert(
                [
                    'class_subject_id' => $csId,
                    'planned_formatif' => 3,
                    'planned_sumatif' => 2,
                    'planned_sumatif_as' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                ['class_subject_id'],
                ['planned_formatif','planned_sumatif','planned_sumatif_as','updated_at']
            );
        }
    }
}
