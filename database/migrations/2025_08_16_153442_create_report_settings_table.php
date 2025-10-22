<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('report_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools');
            $table->foreignId('semester_id')->constrained('semesters');

            $table->string('tempat_cetak', 150)->nullable();
            $table->string('nama_kementerian', 200)->nullable();
            $table->enum('jenis_kertas', ['A4','F4','Letter'])->default('F4');
            $table->decimal('margin_top_cm', 4, 1)->default(0.0);

            $table->enum('format_penulisan_nama', ['Data Asli','Huruf Kapital','Title Case'])->default('Data Asli');
            $table->boolean('tampilkan_nilai_desimal')->default(false);
            $table->boolean('tampilkan_keputusan')->default(true);

            $table->string('label_id_wali', 20)->default('NIP');
            $table->string('label_id_kepsek', 20)->default('NIP');
            $table->string('label_id_siswa_footer', 20)->default('NIS');
            $table->string('judul_rapor', 150)->default('LAPORAN HASIL BELAJAR');

            $table->foreignId('ttd_kepsek_media_id')->nullable()->constrained('media_uploads');
            $table->foreignId('logo_pemda_media_id')->nullable()->constrained('media_uploads');
            $table->foreignId('logo_sekolah_media_id')->nullable()->constrained('media_uploads');

            $table->boolean('p5_on_new_page')->default(false);
            $table->boolean('ekskul_on_new_page')->default(false);
            $table->boolean('catatan_on_new_page')->default(false);

            $table->timestamps();
            $table->unique(['school_id','semester_id'], 'uk_rset');
        });
    }
    public function down(): void { Schema::dropIfExists('report_settings'); }
};
