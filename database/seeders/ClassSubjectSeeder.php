<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSubjectSeeder extends Seeder
{
    public function run(): void
    {
        $schoolId   = DB::table('schools')->value('id');
        // ambil semester yang 'berjalan' (dari Batch 1)
        $semesterId = DB::table('semesters')->where('status','berjalan')->value('id');
        $classId    = DB::table('classes')->where('nama_kelas','X TKJ 1')->value('id');
        $teacherBI  = DB::table('users')->where('username','guru.bi')->value('id');

        $subjects = DB::table('subjects')->pluck('id','short_name'); // [short=>id]
        $order = 1;
        $data = [];
        foreach (['PAI','PPKn','BI','MTK','BING','INF'] as $short) {
            $data[] = [
                'school_id'  => $schoolId,
                'semester_id'=> $semesterId,
                'class_id'   => $classId,
                'subject_id' => $subjects[$short],
                'order_no'   => $order++,
                'teacher_id' => $short==='BI' ? $teacherBI : null,
                'combined_with_id' => null,
                'group'      => null,
                'active'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // insert satu per satu agar dapatkan id utk kebutuhan lain kalau perlu
        foreach ($data as $row) {
            // hindari duplicate unique (semester,class,subject)
            $exists = DB::table('class_subjects')->where([
                'semester_id'=>$row['semester_id'],
                'class_id'=>$row['class_id'],
                'subject_id'=>$row['subject_id'],
            ])->exists();

            if (!$exists) DB::table('class_subjects')->insert($row);
        }
    }
}
