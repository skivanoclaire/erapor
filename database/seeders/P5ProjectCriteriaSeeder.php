<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class P5ProjectCriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $projectId = DB::table('p5_projects')
            ->orderByDesc('id')->value('id');
        if (!$projectId) return;

        for ($i=1; $i<=3; $i++) {
            DB::table('p5_project_criteria')->updateOrInsert(
                ['p5_project_id'=>$projectId,'order_no'=>$i],
                ['title'=>"Kriteria $i",'updated_at'=>now(),'created_at'=>now()]
            );
        }
    }
}
