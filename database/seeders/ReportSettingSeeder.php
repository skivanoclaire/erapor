<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportSettingSeeder extends Seeder
{
    public function run(): void
    {
        $schoolId   = DB::table('schools')->where('npsn','30456789')->value('id') ?? DB::table('schools')->value('id');
        $semesterId = DB::table('semesters')->where('status','berjalan')->value('id');
        if (!$schoolId || !$semesterId) return;

        $pemda = DB::table('media_uploads')->where('path','uploads/logo/pemda.png')->value('id');
        $sekolah = DB::table('media_uploads')->where('path','uploads/logo/sekolah.png')->value('id');
        $ttdKepsek = DB::table('media_uploads')->where('path','uploads/signatures/kepsek.png')->value('id');

        DB::table('report_settings')->updateOrInsert(
            ['school_id'=>$schoolId, 'semester_id'=>$semesterId],
            [
                'tempat_cetak'=>'Tanjung Selor',
                'nama_kementerian'=>'Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi',
                'jenis_kertas'=>'F4',
                'margin_top_cm'=>1.5,
                'format_penulisan_nama'=>'Data Asli',
                'tampilkan_nilai_desimal'=>0,
                'tampilkan_keputusan'=>1,
                'label_id_wali'=>'NIP',
                'label_id_kepsek'=>'NIP',
                'label_id_siswa_footer'=>'NIS',
                'judul_rapor'=>'LAPORAN HASIL BELAJAR',
                'ttd_kepsek_media_id'=>$ttdKepsek,
                'logo_pemda_media_id'=>$pemda,
                'logo_sekolah_media_id'=>$sekolah,
                'p5_on_new_page'=>0,
                'ekskul_on_new_page'=>0,
                'catatan_on_new_page'=>0,
                'updated_at'=>now(),
                'created_at'=>now(),
            ]
        );
    }
}
