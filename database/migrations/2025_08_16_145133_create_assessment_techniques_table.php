<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assessment_techniques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools');
            $table->string('name', 100);
            $table->string('short_name', 20);
            $table->timestamps();
            $table->unique(['school_id','short_name'], 'uk_at');
        });
    }
    public function down(): void { Schema::dropIfExists('assessment_techniques'); }
};
