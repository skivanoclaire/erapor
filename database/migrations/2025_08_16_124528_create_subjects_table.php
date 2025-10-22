<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('short_name', 20);
            $table->string('group', 50)->nullable();   // kelompok mapel (opsional)
            $table->boolean('global_active')->default(true);
            $table->timestamps();

            $table->unique(['short_name'], 'uk_subj_short');
        });
    }
    public function down(): void { Schema::dropIfExists('subjects'); }
};
