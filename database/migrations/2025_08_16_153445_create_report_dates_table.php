<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('report_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_id')->constrained('semesters');
            $table->foreignId('class_id')->constrained('classes');
            $table->date('mid_report_date')->nullable();
            $table->date('final_report_date')->nullable();
            $table->timestamps();
            $table->unique(['semester_id','class_id'], 'uk_rdate');
        });
    }
    public function down(): void { Schema::dropIfExists('report_dates'); }
};
