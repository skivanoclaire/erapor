<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExtracurricularMemberSeeder extends Seeder
{
    public function run(): void
    {
        $semesterId = DB::table('semesters')->where('status','berjalan')->value('id');
        if (!$semesterId) return;

        $exId = DB::table('extracurriculars')->where('name','Pramuka')->value('id');
        if (!$exId) return;

        $classId = DB::table('classes')->where('nama_kelas','X TKJ 1')->value('id');
        $students = DB::table('students')->where('class_id',$classId)->orderBy('id')->limit(5)->pluck('id');

        foreach ($students as $sid) {
            DB::table('extracurricular_members')->updateOrInsert(
                ['extracurricular_id'=>$exId, 'semester_id'=>$semesterId, 'student_id'=>$sid],
                ['updated_at'=>now(), 'created_at'=>now()]
            );
        }
    }
}
