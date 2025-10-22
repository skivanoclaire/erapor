<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('assessment_plans', function (Blueprint $table) {
            // setelah kolom planned_sumatif_as
            $table->decimal('weight_formatif', 5, 2)->default(0.00)->after('planned_sumatif_as');
            $table->decimal('weight_sumatif', 5, 2)->default(1.00)->after('weight_formatif');
            $table->decimal('weight_sumatif_as', 5, 2)->default(1.00)->after('weight_sumatif');
        });
    }

    public function down(): void {
        Schema::table('assessment_plans', function (Blueprint $table) {
            $table->dropColumn(['weight_formatif','weight_sumatif','weight_sumatif_as']);
        });
    }
};
