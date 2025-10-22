<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students');
            $table->foreignId('semester_id')->constrained('semesters');
            $table->unsignedInteger('sakit')->default(0);
            $table->unsignedInteger('izin')->default(0);
            $table->unsignedInteger('alpa')->default(0);
            $table->timestamps();
            $table->unique(['student_id','semester_id'], 'uk_att');
        });
    }
    public function down(): void { Schema::dropIfExists('attendances'); }
};
