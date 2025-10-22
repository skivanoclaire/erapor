<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('schools')->upsert([
            [
                'npsn' => '30456789',                // conflict target
                'jenjang' => 'SMK',
                'nss' => '40.2.34.56.78',
                'nama_sekolah' => 'SMK Negeri Contoh 1',
                'alamat_jalan' => 'Jl. Pendidikan No. 1',
                'desa_kelurahan' => 'Karang Anyar',
                'kecamatan' => 'Tanjung Selor',
                'kabupaten_kota' => 'Bulungan',
                'provinsi' => 'Kalimantan Utara',
                'kode_pos' => '77212',
                'telepon' => '0552-123456',
                'fax' => null,
                'website' => 'https://smkncontoh1.sch.id',
                'email' => 'info@smkncontoh1.sch.id',
                'created_at' => now(),   // akan dipakai hanya saat insert
                'updated_at' => now(),
            ],
        ], ['npsn'], [
            // kolom yang di-update jika bentrok
            'jenjang','nss','nama_sekolah','alamat_jalan','desa_kelurahan','kecamatan',
            'kabupaten_kota','provinsi','kode_pos','telepon','fax','website','email','updated_at'
        ]);
    }
}
