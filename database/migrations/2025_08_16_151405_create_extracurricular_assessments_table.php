<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('extracurricular_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('extracurricular_id')->constrained('extracurriculars');
            $table->foreignId('semester_id')->constrained('semesters');
            $table->foreignId('student_id')->constrained('students');
            $table->enum('mid_grade', ['Sangat Baik','Baik','Cukup','Kurang','-'])->nullable();
            $table->text('mid_description')->nullable();
            $table->enum('final_grade', ['Sangat Baik','Baik','Cukup','Kurang','-'])->nullable();
            $table->text('final_description')->nullable();
            $table->timestamps();

            $table->unique(['extracurricular_id','semester_id','student_id'], 'uk_exa');
        });
    }
    public function down(): void { Schema::dropIfExists('extracurricular_assessments'); }
};
