<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pkl_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pkl_group_id')->constrained('pkl_groups');
            $table->foreignId('student_id')->constrained('students');
            $table->enum('grade', ['Sangat Baik','Baik','Cukup','Kurang','-'])->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['pkl_group_id','student_id'], 'uk_pkla');
        });
    }
    public function down(): void { Schema::dropIfExists('pkl_assessments'); }
};
