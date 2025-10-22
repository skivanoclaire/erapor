<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExtracurricularSeeder extends Seeder
{
    public function run(): void
    {
        $schoolId = DB::table('schools')->where('npsn','30456789')->value('id') ?? DB::table('schools')->value('id');
        $mentorId = DB::table('users')->where('username','wali.x')->value('id');

        DB::table('extracurriculars')->updateOrInsert(
            ['school_id'=>$schoolId, 'name'=>'Pramuka'],
            ['mentor_id'=>$mentorId, 'active'=>1, 'updated_at'=>now(), 'created_at'=>now()]
        );
    }
}
