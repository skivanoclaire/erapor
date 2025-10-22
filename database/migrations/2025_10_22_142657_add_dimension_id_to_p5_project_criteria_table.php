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
        Schema::table('p5_project_criteria', function (Blueprint $table) {
            // Tambahkan kolom dimension_id setelah order_no
            // 1=Beriman, 2=Bernalar Kritis, 3=Mandiri, 4=Berkebinekaan, 5=Kreatif, 6=Bergotong Royong
            $table->tinyInteger('dimension_id')->nullable()->after('order_no')->comment('1-6 untuk 6 dimensi profil pelajar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('p5_project_criteria', function (Blueprint $table) {
            $table->dropColumn('dimension_id');
        });
    }
};
