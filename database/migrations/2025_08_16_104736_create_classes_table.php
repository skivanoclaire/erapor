<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools');
            $table->string('nama_kelas', 100);
            $table->string('tingkat_pendidikan', 20);   // 10/11/12
            $table->foreignId('wali_kelas_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('classes'); }
};
