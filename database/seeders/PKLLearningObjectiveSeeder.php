<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PKLLearningObjectiveSeeder extends Seeder
{
    public function run(): void
    {
        $schoolId   = DB::table('schools')->where('npsn','30456789')->value('id') ?? DB::table('schools')->value('id');
        $semesterId = DB::table('semesters')->where('status','berjalan')->value('id');
        $classXI    = DB::table('classes')->where('nama_kelas','XI TKJ 1')->value('id');

        if (!$schoolId || !$semesterId) return;

        DB::table('pkl_learning_objectives')->updateOrInsert(
            [
                'school_id' => $schoolId,
                'semester_id' => $semesterId,
                'class_id' => $classXI,
                'title' => 'Instalasi Jaringan Dasar',
            ],
            [
                'description' => 'Siswa mampu melakukan instalasi dan konfigurasi LAN sederhana.',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
