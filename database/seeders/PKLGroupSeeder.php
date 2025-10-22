<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PKLGroupSeeder extends Seeder
{
    public function run(): void
    {
        $schoolId   = DB::table('schools')->where('npsn','30456789')->value('id') ?? DB::table('schools')->value('id');
        $semesterId = DB::table('semesters')->where('status','berjalan')->value('id');
        $classXI    = DB::table('classes')->where('nama_kelas','XI TKJ 1')->value('id') ?? DB::table('classes')->value('id');
        $objId      = DB::table('pkl_learning_objectives')->where('semester_id',$semesterId)->where('class_id',$classXI)->value('id');
        $pembimbing = DB::table('users')->where('username','guru.bi')->value('id') ?? DB::table('users')->value('id');

        if (!$schoolId || !$semesterId || !$classXI) return;

        DB::table('pkl_groups')->upsert([
            [
                'school_id' => $schoolId,
                'semester_id' => $semesterId,
                'class_id' => $classXI,
                'sk_penugasan' => 'SK/PKL/001/2025',
                'tempat_pkl' => 'PT Kaltara Network',
                'pembimbing_id' => $pembimbing,
                'learning_objective_id' => $objId,
                'started_at' => now()->toDateString(),
                'ended_at' => now()->addMonths(3)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['semester_id','class_id','sk_penugasan'], [
            'tempat_pkl','pembimbing_id','learning_objective_id','started_at','ended_at','updated_at'
        ]);
    }
}
