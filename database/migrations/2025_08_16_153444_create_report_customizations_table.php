<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('report_customizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools');
            $table->enum('apply_to', ['Rapor Tengah Semester','Rapor Akhir Semester']);
            $table->string('font_family', 50)->default('Arial');
            $table->decimal('title_font_size', 4,1)->default(18.0);
            $table->decimal('table_header_font_size', 4,1)->default(12.0);
            $table->decimal('table_body_font_size', 4,1)->default(12.0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('report_customizations'); }
};
