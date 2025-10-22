<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportDateSeeder extends Seeder
{
    public function run(): void
    {
        $semesterId = DB::table('semesters')->where('status','berjalan')->value('id');
        $classId    = DB::table('classes')->where('nama_kelas','X TKJ 1')->value('id');
        if (!$semesterId || !$classId) return;

        DB::table('report_dates')->updateOrInsert(
            ['semester_id'=>$semesterId,'class_id'=>$classId],
            [
                'mid_report_date'=>now()->addMonths(3)->toDateString(),
                'final_report_date'=>now()->addMonths(6)->toDateString(),
                'updated_at'=>now(),
                'created_at'=>now(),
            ]
        );
    }
}
