<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class P5ProjectRatingSeeder extends Seeder
{
    public function run(): void
    {
        $projectId = DB::table('p5_projects')->orderByDesc('id')->value('id');
        if (!$projectId) return;

        $criteria = DB::table('p5_project_criteria')->where('p5_project_id',$projectId)->pluck('id');
        $students = DB::table('p5_project_students')->where('p5_project_id',$projectId)->pluck('student_id');

        foreach ($criteria as $cid) {
            foreach ($students as $sid) {
                DB::table('p5_project_ratings')->updateOrInsert(
                    ['criterion_id'=>$cid,'student_id'=>$sid],
                    [
                        'p5_project_id'=>$projectId,
                        'level'=>'SB',
                        'description'=>'Mencapai indikator dengan baik.',
                        'updated_at'=>now(),
                        'created_at'=>now(),
                    ]
                );
            }
        }
    }
}
