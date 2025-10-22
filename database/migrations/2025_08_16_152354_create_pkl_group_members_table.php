<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pkl_group_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pkl_group_id')->constrained('pkl_groups');
            $table->foreignId('student_id')->constrained('students');
            $table->timestamps();

            $table->unique(['pkl_group_id','student_id'], 'uk_pklm');
        });
    }
    public function down(): void { Schema::dropIfExists('pkl_group_members'); }
};
