<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools');
            $table->string('nisn', 20)->unique('uk_students_nisn');
            $table->string('nama', 150);
            $table->foreignId('class_id')->nullable()->constrained('classes');
            $table->enum('jk', ['L','P']);
            $table->date('tanggal_lahir')->nullable();
            $table->string('nomor_rumah', 50)->nullable();
            $table->string('nomor_hp', 50)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('students'); }
};
