<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CocurricularActivitySeeder extends Seeder
{
    public function run(): void
    {
        $schoolId   = DB::table('schools')->where('npsn','30456789')->value('id') ?? DB::table('schools')->value('id');
        $semesterId = DB::table('semesters')->where('status','berjalan')->value('id');
        $classId    = DB::table('classes')->where('nama_kelas','X TKJ 1')->value('id');
        $mentorId   = DB::table('users')->where('username','wali.x')->value('id');

        if (!$schoolId || !$semesterId) return;

        DB::table('cocurricular_activities')->updateOrInsert(
            ['school_id'=>$schoolId,'semester_id'=>$semesterId,'class_id'=>$classId,'name'=>'Kunjungan Industri'],
            [
                'dimension'=>'Gotong Royong',
                'mentor_id'=>$mentorId,
                'active'=>1,
                'updated_at'=>now(),
                'created_at'=>now(),
            ]
        );
    }
}
