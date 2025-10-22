<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RaporPaymentSeeder extends Seeder
{
    public function run(): void
    {
        $schoolId   = DB::table('schools')->where('npsn','30456789')->value('id') ?? DB::table('schools')->value('id');
        $semester   = DB::table('semesters')->where('status','berjalan')->first();
        if (!$schoolId || !$semester) return;

        // contoh invoice: INV-{TAHUN}-{4 digit}
        $year = now()->format('Y');
        $invoiceNo = "INV-{$year}-0001";

        DB::table('rapor_payments')->upsert([
            [
                'school_id'   => $schoolId,
                'semester_id' => $semester->id,
                'invoice_no'  => $invoiceNo,
                'description' => "Cetak rapor semester {$semester->semester} {$semester->tahun_ajaran}",
                'amount'      => 250000, // Rp250.000
                'method'      => 'QRIS',
                'status'      => 'UNPAID',
                'issued_at'   => now(),
                'paid_at'     => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ], ['invoice_no'], [
            'school_id','semester_id','description','amount','method','status','issued_at','paid_at','updated_at'
        ]);
    }
}
