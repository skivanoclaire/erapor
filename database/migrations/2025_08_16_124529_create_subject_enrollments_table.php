<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('subject_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools');
            $table->foreignId('semester_id')->constrained('semesters');
            $table->foreignId('class_id')->constrained('classes');
            $table->foreignId('class_subject_id')->constrained('class_subjects');
            $table->foreignId('student_id')->constrained('students');
            $table->boolean('participates')->default(true);
            $table->timestamps();

            $table->unique(['semester_id','class_id','class_subject_id','student_id'], 'uk_se');
        });
    }
    public function down(): void { Schema::dropIfExists('subject_enrollments'); }
};
