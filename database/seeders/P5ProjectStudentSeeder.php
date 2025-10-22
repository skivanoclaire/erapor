<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class P5ProjectStudentSeeder extends Seeder
{
    public function run(): void
    {
        $project = DB::table('p5_projects')->orderByDesc('id')->first();
        if (!$project) return;

        $students = DB::table('students')
            ->where('class_id', $project->class_id)
            ->pluck('id');

        foreach ($students as $sid) {
            DB::table('p5_project_students')->updateOrInsert(
                ['p5_project_id'=>$project->id,'student_id'=>$sid],
                ['updated_at'=>now(),'created_at'=>now()]
            );
        }
    }
}
