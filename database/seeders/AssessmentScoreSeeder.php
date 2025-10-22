<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssessmentScoreSeeder extends Seeder
{
    public function run(): void
    {
        $biCsId = DB::table('class_subjects')
            ->join('subjects','subjects.id','=','class_subjects.subject_id')
            ->join('semesters','semesters.id','=','class_subjects.semester_id')
            ->where('subjects.short_name','BI')
            ->where('semesters.status','berjalan')
            ->value('class_subjects.id');

        if (!$biCsId) return;

        $assessments = DB::table('assessments')->where('class_subject_id',$biCsId)->pluck('id');
        $studentIds  = DB::table('subject_enrollments')->where('class_subject_id',$biCsId)->pluck('student_id')->unique();

        foreach ($assessments as $aid) {
            foreach ($studentIds as $sid) {
                DB::table('assessment_scores')->updateOrInsert(
                    ['assessment_id'=>$aid,'student_id'=>$sid],
                    ['score'=>rand(70,95),'note'=>null,'updated_at'=>now(),'created_at'=>now()]
                );
            }
        }
    }
}
