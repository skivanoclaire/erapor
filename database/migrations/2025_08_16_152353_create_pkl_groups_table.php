<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pkl_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools');
            $table->foreignId('semester_id')->constrained('semesters');
            $table->foreignId('class_id')->constrained('classes');
            $table->string('sk_penugasan', 100);
            $table->string('tempat_pkl', 200);
            $table->foreignId('pembimbing_id')->nullable()->constrained('users');
            $table->foreignId('learning_objective_id')->nullable()->constrained('pkl_learning_objectives');
            $table->date('started_at')->nullable();
            $table->date('ended_at')->nullable();
            $table->timestamps();

            $table->unique(['semester_id','class_id','sk_penugasan'], 'uk_pkgl');
        });
    }
    public function down(): void { Schema::dropIfExists('pkl_groups'); }
};
