<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
public function run(): void
{
    $this->call([
        // Batch 1
        SchoolSeeder::class,
        SchoolHeadSeeder::class,
        SemesterSeeder::class,
        // Batch 2
        UserSeeder::class,
        ClassSeeder::class,
        StudentSeeder::class,
        // Batch 3
        SubjectSeeder::class,
        ClassSubjectSeeder::class,
        SubjectEnrollmentSeeder::class,
        // Batch 4
        AssessmentTechniqueSeeder::class,
        AssessmentPlanSeeder::class,
        AssessmentSeeder::class,
        AssessmentScoreSeeder::class,
        FinalGradeSeeder::class,
        // Batch 5
        AttendanceSeeder::class,
        NoteSeeder::class,
        PromotionSeeder::class,
        // Batch 6 – P5BK
        P5ProjectSeeder::class,
        P5ProjectCriteriaSeeder::class,
        P5ProjectStudentSeeder::class,
        P5ProjectRatingSeeder::class,
        // Batch 7 – Ekstrakurikuler
        ExtracurricularSeeder::class,
        ExtracurricularMemberSeeder::class,
        ExtracurricularAssessmentSeeder::class,
        // Batch 8 – PKL/Prakerin
        PKLLearningObjectiveSeeder::class,
        PKLGroupSeeder::class,
        PKLGroupMemberSeeder::class,
        PKLAssessmentSeeder::class,
        // Batch 9 – Kokurikuler
        CocurricularActivitySeeder::class,
        CocurricularMemberSeeder::class,
        CocurricularAssessmentSeeder::class,
        // Batch 10 – Pembayaran Rapor
        RaporPaymentSeeder::class,
        // Batch 11 – Pengaturan & Kustom Rapor
        MediaUploadSeeder::class,
        ReportSettingSeeder::class,
        ReportWaliSignatureSeeder::class,
        ReportCustomizationSeeder::class,
        ReportDateSeeder::class,
    ]);
    
}

}
