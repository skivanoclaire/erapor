<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectEnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $schoolId   = DB::table('schools')->value('id');
        $semesterId = DB::table('semesters')->where('status','berjalan')->value('id');
        $classId    = DB::table('classes')->where('nama_kelas','X TKJ 1')->value('id');

        $classSubjects = DB::table('class_subjects')
            ->where('semester_id',$semesterId)
            ->where('class_id',$classId)
            ->pluck('id');

        $students = DB::table('students')->where('class_id',$classId)->pluck('id');

        foreach ($students as $sid) {
            foreach ($classSubjects as $csId) {
                $exists = DB::table('subject_enrollments')->where([
                    'semester_id' => $semesterId,
                    'class_id' => $classId,
                    'class_subject_id' => $csId,
                    'student_id' => $sid,
                ])->exists();

                if (!$exists) {
                    DB::table('subject_enrollments')->insert([
                        'school_id' => $schoolId,
                        'semester_id' => $semesterId,
                        'class_id' => $classId,
                        'class_subject_id' => $csId,
                        'student_id' => $sid,
                        'participates' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
