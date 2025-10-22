<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['name'=>'Pendidikan Agama','short_name'=>'PAI','group'=>'A'],
            ['name'=>'PPKn','short_name'=>'PPKn','group'=>'A'],
            ['name'=>'Bahasa Indonesia','short_name'=>'BI','group'=>'A'],
            ['name'=>'Matematika','short_name'=>'MTK','group'=>'A'],
            ['name'=>'Bahasa Inggris','short_name'=>'BING','group'=>'A'],
            ['name'=>'Informatika','short_name'=>'INF','group'=>'C1'],
        ];

        foreach ($rows as $r) {
            DB::table('subjects')->updateOrInsert(
                ['short_name'=>$r['short_name']],
                $r + ['global_active'=>1,'created_at'=>now(),'updated_at'=>now()]
            );
        }
    }
}
