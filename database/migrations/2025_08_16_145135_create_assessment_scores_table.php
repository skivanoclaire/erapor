<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assessment_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('assessments');
            $table->foreignId('student_id')->constrained('students');
            $table->decimal('score', 6, 2)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->unique(['assessment_id','student_id'], 'uk_sc');
        });
    }
    public function down(): void { Schema::dropIfExists('assessment_scores'); }
};
