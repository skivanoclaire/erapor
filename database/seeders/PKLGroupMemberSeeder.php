<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PKLGroupMemberSeeder extends Seeder
{
    public function run(): void
    {
        $groupId = DB::table('pkl_groups')->value('id');
        if (!$groupId) return;

        // coba ambil siswa kelas XI; kalau kosong, fallback ke kelas X
        $classXI = DB::table('classes')->where('nama_kelas','XI TKJ 1')->value('id');
        $classX  = DB::table('classes')->where('nama_kelas','X TKJ 1')->value('id');
        $students = DB::table('students')->whereIn('class_id', array_filter([$classXI, $classX]))
                    ->orderBy('id')->limit(3)->pluck('id');

        foreach ($students as $sid) {
            DB::table('pkl_group_members')->updateOrInsert(
                ['pkl_group_id'=>$groupId,'student_id'=>$sid],
                ['updated_at'=>now(),'created_at'=>now()]
            );
        }
    }
}
