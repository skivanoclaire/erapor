<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssessmentTechniqueSeeder extends Seeder
{
    public function run(): void
    {
        $schoolId = DB::table('schools')->value('id');

        $rows = [
            ['school_id'=>$schoolId,'name'=>'Tes Tertulis','short_name'=>'tulis'],
            ['school_id'=>$schoolId,'name'=>'Penugasan','short_name'=>'tugas'],
            ['school_id'=>$schoolId,'name'=>'Proyek','short_name'=>'proy'],
            ['school_id'=>$schoolId,'name'=>'Praktik','short_name'=>'prak'],
        ];

        foreach ($rows as $r) {
            DB::table('assessment_techniques')->upsert(
                $r + ['created_at'=>now(),'updated_at'=>now()],
                ['school_id','short_name'],
                ['name','updated_at']
            );
        }
    }
}
