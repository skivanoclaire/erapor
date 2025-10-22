<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rapor_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools');
            $table->foreignId('semester_id')->constrained('semesters');
            $table->string('invoice_no', 50)->unique('uk_pay_invoice');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('amount'); // rupiah tanpa koma
            $table->enum('method', ['Transfer','VA','QRIS','Lainnya'])->default('Transfer');
            $table->enum('status', ['UNPAID','PAID','CANCELLED'])->default('UNPAID');
            $table->dateTime('issued_at')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('rapor_payments');
    }
};
