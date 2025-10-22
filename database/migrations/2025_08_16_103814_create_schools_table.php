<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->enum('jenjang', ['SD','SMP','SMA','SMK','SLB','LAINNYA']);
            $table->string('npsn', 20)->unique('uk_sch_npsn');
            $table->string('nss', 30)->nullable();
            $table->string('nama_sekolah', 200);
            $table->string('alamat_jalan', 200);
            $table->string('desa_kelurahan', 100);
            $table->string('kecamatan', 100);
            $table->string('kabupaten_kota', 100);
            $table->string('provinsi', 100);
            $table->string('kode_pos', 10)->nullable();
            $table->string('telepon', 30)->nullable();
            $table->string('fax', 30)->nullable();
            $table->string('website', 200)->nullable();
            $table->string('email', 150);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('schools'); }
};
