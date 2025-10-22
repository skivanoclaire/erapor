<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $schoolId = DB::table('schools')->value('id');

        DB::table('users')->insert([
            [
                'school_id' => $schoolId,
                'username' => 'kepsek',
                'password' => Hash::make('password'),
                'nama' => 'Samsul Arifin',
                'jenis_ptk' => 'kepala_sekolah',
                'ptk_aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'school_id' => $schoolId,
                'username' => 'operator',
                'password' => Hash::make('password'),
                'nama' => 'Bayu Operator',
                'jenis_ptk' => 'operator',
                'ptk_aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'school_id' => $schoolId,
                'username' => 'guru.bi',
                'password' => Hash::make('password'),
                'nama' => 'Dewi Bahasa',
                'jenis_ptk' => 'guru_mapel',
                'ptk_aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'school_id' => $schoolId,
                'username' => 'wali.x',
                'password' => Hash::make('password'),
                'nama' => 'Budi Wali',
                'jenis_ptk' => 'guru',
                'ptk_aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
