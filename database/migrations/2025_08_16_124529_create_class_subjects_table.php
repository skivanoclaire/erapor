<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('class_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools');
            $table->foreignId('semester_id')->constrained('semesters');
            $table->foreignId('class_id')->constrained('classes');
            $table->foreignId('subject_id')->constrained('subjects');
            $table->unsignedInteger('order_no')->default(1);
            $table->foreignId('teacher_id')->nullable()->constrained('users');
            $table->foreignId('combined_with_id')->nullable()->constrained('class_subjects'); // self-FK
            $table->string('group', 50)->nullable();   // override kelompok mapel
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->unique(['semester_id','class_id','subject_id'], 'uk_cs');
        });
    }
    public function down(): void { Schema::dropIfExists('class_subjects'); }
};
