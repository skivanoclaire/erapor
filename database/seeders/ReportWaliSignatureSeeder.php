<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportWaliSignatureSeeder extends Seeder
{
    public function run(): void
    {
        $semesterId = DB::table('semesters')->where('status','berjalan')->value('id');
        $classId    = DB::table('classes')->where('nama_kelas','X TKJ 1')->value('id');
        if (!$semesterId || !$classId) return;

        $waliId     = DB::table('users')->where('username','wali.x')->value('id');
        $sigMediaId = DB::table('media_uploads')->where('path','uploads/signatures/wali_x.png')->value('id');

        DB::table('report_wali_signatures')->updateOrInsert(
            ['semester_id'=>$semesterId, 'class_id'=>$classId],
            [
                'wali_id'=>$waliId,
                'signature_media_id'=>$sigMediaId,
                'updated_at'=>now(),
                'created_at'=>now(),
            ]
        );
    }
}
