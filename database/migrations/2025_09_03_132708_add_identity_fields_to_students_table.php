<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Identitas dasar
            $table->string('nis', 30)->nullable()->after('school_id');
            $table->string('nik', 30)->nullable()->after('nisn');
            $table->string('tempat_lahir', 100)->nullable()->after('nama');
            // tanggal_lahir sudah ada
            $table->string('agama', 30)->nullable()->after('jk');
            $table->string('status_dalam_keluarga', 50)->nullable()->after('agama');
            $table->unsignedTinyInteger('anak_ke')->nullable()->after('status_dalam_keluarga');
            $table->text('alamat')->nullable()->after('nomor_hp');

            // Fisik
            $table->unsignedSmallInteger('berat_badan')->nullable()->after('alamat');   // kg
            $table->unsignedSmallInteger('tinggi_badan')->nullable()->after('berat_badan'); // cm

            // Riwayat masuk
            $table->string('sekolah_asal', 150)->nullable()->after('tinggi_badan');
            $table->date('tanggal_masuk_sekolah')->nullable()->after('sekolah_asal');
            $table->string('diterima_di_kelas', 50)->nullable()->after('tanggal_masuk_sekolah');

            // Orang Tua
            $table->string('nama_ayah', 150)->nullable()->after('diterima_di_kelas');
            $table->string('pekerjaan_ayah', 100)->nullable()->after('nama_ayah');
            $table->string('nama_ibu', 150)->nullable()->after('pekerjaan_ayah');
            $table->string('pekerjaan_ibu', 100)->nullable()->after('nama_ibu');
            $table->string('telepon_rumah', 30)->nullable()->after('pekerjaan_ibu');
            $table->text('alamat_orang_tua')->nullable()->after('telepon_rumah');

            // Wali
            $table->string('nama_wali', 150)->nullable()->after('alamat_orang_tua');
            $table->string('pekerjaan_wali', 100)->nullable()->after('nama_wali');
            $table->string('telepon_wali', 30)->nullable()->after('pekerjaan_wali');
            $table->text('alamat_wali')->nullable()->after('telepon_wali');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'nis','nik','tempat_lahir','agama','status_dalam_keluarga','anak_ke',
                'alamat','berat_badan','tinggi_badan','sekolah_asal','tanggal_masuk_sekolah','diterima_di_kelas',
                'nama_ayah','pekerjaan_ayah','nama_ibu','pekerjaan_ibu','telepon_rumah','alamat_orang_tua',
                'nama_wali','pekerjaan_wali','telepon_wali','alamat_wali'
            ]);
        });
    }
};
