<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('school_heads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools');
            $table->string('nip', 30)->nullable();
            $table->string('gelar_depan', 50)->nullable();
            $table->string('nama', 150);
            $table->string('gelar_belakang', 50)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('school_heads'); }
};
