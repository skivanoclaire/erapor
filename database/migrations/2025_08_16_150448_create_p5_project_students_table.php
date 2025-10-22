<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('p5_project_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('p5_project_id')->constrained('p5_projects');
            $table->foreignId('student_id')->constrained('students');
            $table->timestamps();

            $table->unique(['p5_project_id','student_id'], 'uk_p5s');
        });
    }
    public function down(): void { Schema::dropIfExists('p5_project_students'); }
};
