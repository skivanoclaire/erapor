<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CocurricularMemberSeeder extends Seeder
{
    public function run(): void
    {
        $cocuId = DB::table('cocurricular_activities')->where('name','Kunjungan Industri')->orderByDesc('id')->value('id');
        $classX = DB::table('classes')->where('nama_kelas','X TKJ 1')->value('id');
        if (!$cocuId || !$classX) return;

        // Ambil siswa kelas X yang BELUM terdaftar di kegiatan ini
        $existing = DB::table('cocurricular_members')->where('cocurricular_id',$cocuId)->pluck('student_id')->all();
        $students = DB::table('students')
            ->where('class_id',$classX)
            ->whereNotIn('id', $existing)
            ->orderBy('id')->limit(5)->pluck('id');

        foreach ($students as $sid) {
            DB::table('cocurricular_members')->updateOrInsert(
                ['cocurricular_id'=>$cocuId,'student_id'=>$sid],
                ['updated_at'=>now(),'created_at'=>now()]
            );
        }
    }
}
