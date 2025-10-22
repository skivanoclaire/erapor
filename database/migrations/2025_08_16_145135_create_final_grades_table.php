<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('final_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_subject_id')->constrained('class_subjects');
            $table->foreignId('student_id')->constrained('students');
            $table->decimal('final_score', 6, 2);
            $table->dateTime('computed_at')->nullable();
            $table->timestamps();
            $table->unique(['class_subject_id','student_id'], 'uk_fg');
        });
    }
    public function down(): void { Schema::dropIfExists('final_grades'); }
};
