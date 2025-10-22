<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CocurricularAssessmentSeeder extends Seeder
{
    public function run(): void
    {
        $cocuId = DB::table('cocurricular_activities')->where('name','Kunjungan Industri')->orderByDesc('id')->value('id');
        if (!$cocuId) return;

        $members = DB::table('cocurricular_members')->where('cocurricular_id',$cocuId)->pluck('student_id');

        foreach ($members as $sid) {
            DB::table('cocurricular_assessments')->updateOrInsert(
                ['cocurricular_id'=>$cocuId,'student_id'=>$sid],
                [
                    'grade'=>'Baik',
                    'description'=>'Berpartisipasi aktif dalam kunjungan dan diskusi.',
                    'updated_at'=>now(),
                    'created_at'=>now(),
                ]
            );
        }
    }
}
