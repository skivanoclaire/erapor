<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PKLAssessmentSeeder extends Seeder
{
    public function run(): void
    {
        $groupId = DB::table('pkl_groups')->value('id');
        if (!$groupId) return;

        $members = DB::table('pkl_group_members')->where('pkl_group_id',$groupId)->pluck('student_id');

        foreach ($members as $sid) {
            DB::table('pkl_assessments')->updateOrInsert(
                ['pkl_group_id'=>$groupId, 'student_id'=>$sid],
                [
                    'grade' => 'Sangat Baik',
                    'description' => 'Disiplin, komunikatif, dan tuntas menyelesaikan tugas.',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
