<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class P5ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $schoolId   = DB::table('schools')->where('npsn','30456789')->value('id') ?? DB::table('schools')->value('id');
        $semesterId = DB::table('semesters')->where('status','berjalan')->value('id');
        $classId    = DB::table('classes')->where('nama_kelas','X TKJ 1')->value('id');
        $mentorId   = DB::table('users')->where('username','wali.x')->value('id');

        if (!$schoolId || !$semesterId || !$classId) return;

        // kunci unik logis: school+semester+class+theme
        $theme = 'Kearifan Lokal';
        DB::table('p5_projects')->updateOrInsert(
            ['school_id'=>$schoolId,'semester_id'=>$semesterId,'class_id'=>$classId,'theme'=>$theme],
            [
                'subelement_count'=>3,
                'mentor_id'=>$mentorId,
                'active'=>1,
                'updated_at'=>now(),
                'created_at'=>now(),
            ]
        );
    }
}
