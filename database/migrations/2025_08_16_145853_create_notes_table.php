<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students');
            $table->foreignId('semester_id')->constrained('semesters');
            $table->text('catatan_tengah')->nullable();
            $table->text('catatan_akhir')->nullable();
            $table->timestamps();
            $table->unique(['student_id','semester_id'], 'uk_note');
        });
    }
    public function down(): void { Schema::dropIfExists('notes'); }
};
