<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        $semesterId = DB::table('semesters')->where('status','berjalan')->value('id');
        if (!$semesterId) return;

        $students = DB::table('students')->pluck('id');

        foreach ($students as $sid) {
            DB::table('notes')->updateOrInsert(
                ['student_id'=>$sid,'semester_id'=>$semesterId],
                [
                    'catatan_tengah' => 'Pertahankan konsistensi belajar dan kehadiran.',
                    'catatan_akhir'  => 'Meningkat pada beberapa kompetensi; teruskan.',
                    'updated_at'=>now(),
                    'created_at'=>now(),
                ]
            );
        }
    }
}
