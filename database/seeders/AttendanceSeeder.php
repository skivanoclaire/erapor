<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $semesterId = DB::table('semesters')->where('status','berjalan')->value('id');
        if (!$semesterId) return;

        $students = DB::table('students')->pluck('id');

        foreach ($students as $sid) {
            DB::table('attendances')->updateOrInsert(
                ['student_id'=>$sid,'semester_id'=>$semesterId],
                [
                    'sakit' => rand(0,2),
                    'izin'  => rand(0,2),
                    'alpa'  => rand(0,1),
                    'updated_at'=>now(),
                    'created_at'=>now(),
                ]
            );
        }
    }
}
