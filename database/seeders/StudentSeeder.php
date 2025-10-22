<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $schoolId = DB::table('schools')->value('id');
        $kelasXId = DB::table('classes')->where('nama_kelas','X TKJ 1')->value('id');

        $rows = [];
        for ($i=1; $i<=10; $i++) {
            $rows[] = [
                'school_id' => $schoolId,
                'nisn' => '9900'.str_pad((string)$i, 6, '0', STR_PAD_LEFT),
                'nama' => 'Siswa '.sprintf('%02d', $i),
                'class_id' => $kelasXId,
                'jk' => $i % 2 === 0 ? 'L' : 'P',
                'tanggal_lahir' => now()->subYears(16)->subDays($i)->toDateString(),
                'nomor_rumah' => null,
                'nomor_hp' => '0812'.rand(10000000, 99999999),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('students')->insert($rows);
    }
}
