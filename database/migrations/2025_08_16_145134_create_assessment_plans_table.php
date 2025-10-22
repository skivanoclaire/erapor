<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assessment_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_subject_id')->constrained('class_subjects');
            $table->unsignedInteger('planned_formatif')->default(0);
            $table->unsignedInteger('planned_sumatif')->default(0);
            $table->unsignedInteger('planned_sumatif_as')->default(0);
            $table->timestamps();
            $table->unique(['class_subject_id'], 'uk_ap');
        });
    }
    public function down(): void { Schema::dropIfExists('assessment_plans'); }
};
