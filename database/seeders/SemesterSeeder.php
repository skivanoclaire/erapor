<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        $schoolId = DB::table('schools')->where('npsn','30456789')->value('id');

        DB::table('semesters')->upsert([
            [
                'school_id' => $schoolId,
                'tahun_ajaran' => '2024/2025',
                'semester' => 'ganjil',
                'status' => 'tidak_berjalan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'school_id' => $schoolId,
                'tahun_ajaran' => '2024/2025',
                'semester' => 'genap',
                'status' => 'berjalan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['school_id','tahun_ajaran','semester'], [
            'status','updated_at'
        ]);
    }
}
