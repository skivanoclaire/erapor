<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('extracurricular_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('extracurricular_id')->constrained('extracurriculars');
            $table->foreignId('semester_id')->constrained('semesters');
            $table->foreignId('student_id')->constrained('students');
            $table->timestamps();

            $table->unique(['extracurricular_id','semester_id','student_id'], 'uk_exm');
        });
    }
    public function down(): void { Schema::dropIfExists('extracurricular_members'); }
};
