<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_subject_id')->constrained('class_subjects');
            $table->foreignId('technique_id')->nullable()->constrained('assessment_techniques');
            $table->enum('type', ['formatif','sumatif','sumatif_as']);
            $table->string('title', 150);
            $table->date('date')->nullable();
            $table->decimal('max_score', 5, 2)->default(100.00);
            $table->decimal('weight', 5, 2)->default(1.00);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('assessments'); }
};
