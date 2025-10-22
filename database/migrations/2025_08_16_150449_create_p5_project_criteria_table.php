<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('p5_project_criteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('p5_project_id')->constrained('p5_projects');
            $table->unsignedInteger('order_no');
            $table->string('title', 255)->nullable();
            $table->timestamps();

            $table->unique(['p5_project_id','order_no'], 'uk_p5c');
        });
    }
    public function down(): void { Schema::dropIfExists('p5_project_criteria'); }
};
