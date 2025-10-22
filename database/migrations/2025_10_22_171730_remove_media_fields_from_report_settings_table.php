<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('report_settings', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropForeign(['ttd_kepsek_media_id']);
            $table->dropForeign(['logo_pemda_media_id']);
            $table->dropForeign(['logo_sekolah_media_id']);

            // Then drop the columns
            $table->dropColumn([
                'ttd_kepsek_media_id',
                'logo_pemda_media_id',
                'logo_sekolah_media_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('ttd_kepsek_media_id')->nullable();
            $table->unsignedBigInteger('logo_pemda_media_id')->nullable();
            $table->unsignedBigInteger('logo_sekolah_media_id')->nullable();
        });
    }
};
