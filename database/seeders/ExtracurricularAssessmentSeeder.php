<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExtracurricularAssessmentSeeder extends Seeder
{
    public function run(): void
    {
        $semesterId = DB::table('semesters')->where('status','berjalan')->value('id');
        if (!$semesterId) return;

        $exId = DB::table('extracurriculars')->where('name','Pramuka')->value('id');
        if (!$exId) return;

        $members = DB::table('extracurricular_members')
            ->where('extracurricular_id',$exId)
            ->where('semester_id',$semesterId)
            ->pluck('student_id');

        foreach ($members as $sid) {
            DB::table('extracurricular_assessments')->updateOrInsert(
                ['extracurricular_id'=>$exId,'semester_id'=>$semesterId,'student_id'=>$sid],
                [
                    'mid_grade'=>'Baik',
                    'mid_description'=>'Aktif mengikuti kegiatan.',
                    'final_grade'=>'Sangat Baik',
                    'final_description'=>'Menunjukkan kepemimpinan yang baik.',
                    'updated_at'=>now(),
                    'created_at'=>now(),
                ]
            );
        }
    }
}
