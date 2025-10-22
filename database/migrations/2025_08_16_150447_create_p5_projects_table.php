<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('p5_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools');
            $table->foreignId('semester_id')->constrained('semesters');
            $table->foreignId('class_id')->constrained('classes');
            $table->string('theme', 150);
            $table->unsignedInteger('subelement_count')->default(0);
            $table->foreignId('mentor_id')->nullable()->constrained('users');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('p5_projects'); }
};
