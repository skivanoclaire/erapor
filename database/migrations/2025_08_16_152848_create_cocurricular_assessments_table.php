<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cocurricular_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cocurricular_id')->constrained('cocurricular_activities');
            $table->foreignId('student_id')->constrained('students');
            $table->enum('grade', ['Sangat Baik','Baik','Cukup','Kurang','-'])->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['cocurricular_id','student_id'], 'uk_cocoa');
        });
    }
    public function down(): void { Schema::dropIfExists('cocurricular_assessments'); }
};
