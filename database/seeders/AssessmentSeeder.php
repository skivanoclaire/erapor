<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssessmentSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil class_subject Bahasa Indonesia (BI) di semester berjalan
        $biCsId = DB::table('class_subjects')
            ->join('subjects','subjects.id','=','class_subjects.subject_id')
            ->join('semesters','semesters.id','=','class_subjects.semester_id')
            ->where('subjects.short_name','BI')
            ->where('semesters.status','berjalan')
            ->value('class_subjects.id');

        if (!$biCsId) return;

        $techId = DB::table('assessment_techniques')->where('short_name','tulis')->value('id');

        $payload = [
            ['class_subject_id'=>$biCsId,'technique_id'=>$techId,'type'=>'formatif','title'=>'Kuis 1','date'=>now()->toDateString(),'max_score'=>100,'weight'=>1.00],
            ['class_subject_id'=>$biCsId,'technique_id'=>$techId,'type'=>'formatif','title'=>'Kuis 2','date'=>now()->toDateString(),'max_score'=>100,'weight'=>1.00],
            ['class_subject_id'=>$biCsId,'technique_id'=>$techId,'type'=>'sumatif','title'=>'PTS','date'=>now()->toDateString(),'max_score'=>100,'weight'=>1.50],
            ['class_subject_id'=>$biCsId,'technique_id'=>$techId,'type'=>'sumatif_as','title'=>'PAS','date'=>now()->toDateString(),'max_score'=>100,'weight'=>2.00],
        ];

        foreach ($payload as $p) {
            // idempoten berdasar kombinasi class_subject + title + type
            $exists = DB::table('assessments')
                ->where('class_subject_id',$p['class_subject_id'])
                ->where('title',$p['title'])
                ->where('type',$p['type'])
                ->exists();

            if (!$exists) {
                DB::table('assessments')->insert($p + ['created_at'=>now(),'updated_at'=>now()]);
            }
        }
    }
}
