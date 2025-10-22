<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MediaUploadSeeder extends Seeder
{
    public function run(): void
    {
        $schoolId = DB::table('schools')->where('npsn','30456789')->value('id') ?? DB::table('schools')->value('id');

        $rows = [
            ['school_id'=>$schoolId,'path'=>'uploads/logo/pemda.png','mime'=>'image/png','size'=>null],
            ['school_id'=>$schoolId,'path'=>'uploads/logo/sekolah.png','mime'=>'image/png','size'=>null],
            ['school_id'=>$schoolId,'path'=>'uploads/signatures/kepsek.png','mime'=>'image/png','size'=>null],
            ['school_id'=>$schoolId,'path'=>'uploads/signatures/wali_x.png','mime'=>'image/png','size'=>null],
        ];

        foreach ($rows as $r) {
            DB::table('media_uploads')->updateOrInsert(
                ['school_id'=>$r['school_id'], 'path'=>$r['path']],
                $r + ['updated_at'=>now(), 'created_at'=>now()]
            );
        }
    }
}
