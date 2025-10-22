<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools');
            $table->foreignId('semester_id')->constrained('semesters'); // semester evaluasi
            $table->foreignId('class_id')->constrained('classes');      // kelas asal
            $table->foreignId('student_id')->constrained('students');
            $table->boolean('promoted')->default(true);
            $table->foreignId('next_class_id')->nullable()->constrained('classes'); // kelas tujuan
            $table->text('note')->nullable();
            $table->dateTime('decided_at')->nullable();
            $table->timestamps();
            $table->unique(['semester_id','class_id','student_id'], 'uk_prom');
        });
    }
    public function down(): void { Schema::dropIfExists('promotions'); }
};
