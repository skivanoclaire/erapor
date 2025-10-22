<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportCustomizationSeeder extends Seeder
{
    public function run(): void
    {
        $schoolId = DB::table('schools')->where('npsn','30456789')->value('id') ?? DB::table('schools')->value('id');

        $rows = [
            ['school_id'=>$schoolId,'apply_to'=>'Rapor Tengah Semester','font_family'=>'Arial','title_font_size'=>18.0,'table_header_font_size'=>12.0,'table_body_font_size'=>12.0],
            ['school_id'=>$schoolId,'apply_to'=>'Rapor Akhir Semester','font_family'=>'Arial','title_font_size'=>18.0,'table_header_font_size'=>12.0,'table_body_font_size'=>12.0],
        ];
        foreach ($rows as $r) {
            DB::table('report_customizations')->updateOrInsert(
                ['school_id'=>$r['school_id'],'apply_to'=>$r['apply_to']],
                $r + ['updated_at'=>now(),'created_at'=>now()]
            );
        }
    }
}
