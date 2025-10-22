<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools');
            $table->string('username', 100)->unique('uk_users_username');
            $table->string('password', 255);
            $table->string('nik', 20)->nullable();
            $table->string('nip', 30)->nullable();
            $table->string('gelar_depan', 50)->nullable();
            $table->string('nama', 150);
            $table->string('gelar_belakang', 50)->nullable();
            $table->enum('jenis_ptk', ['guru','guru_mapel','kepala_sekolah','operator','pembina','pembimbing_pkl'])->default('guru');
            $table->boolean('ptk_aktif')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('users'); }
};
