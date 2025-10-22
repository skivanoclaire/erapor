<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolHeadSeeder extends Seeder
{
    public function run(): void
    {
        $schoolId = DB::table('schools')->where('npsn','30456789')->value('id');

        DB::table('school_heads')->updateOrInsert(
            ['school_id' => $schoolId], // kunci pencarian
            [
                'nip' => '19781231 200501 1 001',
                'gelar_depan' => null,
                'nama' => 'Rahmat Hidayat',
                'gelar_belakang' => 'S.Pd., M.Pd.',
                'updated_at' => now(),
                'created_at' => now(), // akan overwrite kalau record sudah ada (OK untuk dev)
            ]
        );
    }
}
