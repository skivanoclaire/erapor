<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('report_wali_signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_id')->constrained('semesters');
            $table->foreignId('class_id')->constrained('classes');
            $table->foreignId('wali_id')->nullable()->constrained('users');
            $table->foreignId('signature_media_id')->nullable()->constrained('media_uploads');
            $table->timestamps();
            $table->unique(['semester_id','class_id'], 'uk_rws');
        });
    }
    public function down(): void { Schema::dropIfExists('report_wali_signatures'); }
};
