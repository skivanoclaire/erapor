<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        $schoolId   = DB::table('schools')->where('npsn','30456789')->value('id') ?? DB::table('schools')->value('id');
        $semesterId = DB::table('semesters')->where('status','berjalan')->value('id');
        if (!$schoolId || !$semesterId) return;

        // kelas asal & tujuan (contoh: X TKJ 1 -> XI TKJ 1)
        $classFrom = DB::table('classes')->where('nama_kelas','X TKJ 1')->value('id');
        $classTo   = DB::table('classes')->where('nama_kelas','XI TKJ 1')->value('id');

        if (!$classFrom) return;

        $students = DB::table('students')->where('class_id',$classFrom)->pluck('id');

        foreach ($students as $sid) {
            DB::table('promotions')->updateOrInsert(
                ['semester_id'=>$semesterId,'class_id'=>$classFrom,'student_id'=>$sid],
                [
                    'school_id' => $schoolId,
                    'promoted' => 1,
                    'next_class_id' => $classTo, // bisa null jika belum ditentukan
                    'note' => $classTo ? 'Naik kelas' : 'Keputusan promosi ditetapkan, kelas tujuan belum ditentukan',
                    'decided_at' => now(),
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
