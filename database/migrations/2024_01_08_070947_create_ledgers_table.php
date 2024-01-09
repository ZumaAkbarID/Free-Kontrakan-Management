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
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID anggota
            $table->string('transaction_purpose'); // Tujuan transaksi
            $table->decimal('amount', 10, 2)->default(0.00); // Jumlah transaksi
            $table->decimal('final_balance', 10, 2)->default(0.00); // Saldo akhir
            $table->string('manual_prof')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledgers');
    }
};
