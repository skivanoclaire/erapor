<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cocurricular_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools');
            $table->foreignId('semester_id')->constrained('semesters');
            $table->foreignId('class_id')->nullable()->constrained('classes');
            $table->string('name', 200);
            $table->string('dimension', 150)->nullable(); // dimensi karakter, dll
            $table->foreignId('mentor_id')->nullable()->constrained('users');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('cocurricular_activities'); }
};
