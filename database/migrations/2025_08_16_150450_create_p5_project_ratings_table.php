<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('p5_project_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('p5_project_id')->constrained('p5_projects');
            $table->foreignId('criterion_id')->constrained('p5_project_criteria');
            $table->foreignId('student_id')->constrained('students');
            $table->enum('level', ['MB','BSH','SB','SAB','-'])->default('MB');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['criterion_id','student_id'], 'uk_p5r');
        });
    }
    public function down(): void { Schema::dropIfExists('p5_project_ratings'); }
};
