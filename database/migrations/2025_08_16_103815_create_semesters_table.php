<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools');
            $table->string('tahun_ajaran', 20); // 2024/2025
            $table->enum('semester', ['ganjil','genap']);
            $table->enum('status', ['berjalan','tidak_berjalan'])->default('tidak_berjalan');
            $table->timestamps();
            $table->unique(['school_id','tahun_ajaran','semester'], 'uk_sem');
        });
    }
    public function down(): void { Schema::dropIfExists('semesters'); }
};
