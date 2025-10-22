<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $schoolId = DB::table('schools')->value('id');
        $waliXId  = DB::table('users')->where('username','wali.x')->value('id');

        DB::table('classes')->insert([
            [
                'school_id' => $schoolId,
                'nama_kelas' => 'X TKJ 1',
                'tingkat_pendidikan' => '10',
                'wali_kelas_id' => $waliXId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'school_id' => $schoolId,
                'nama_kelas' => 'XI TKJ 1',
                'tingkat_pendidikan' => '11',
                'wali_kelas_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
