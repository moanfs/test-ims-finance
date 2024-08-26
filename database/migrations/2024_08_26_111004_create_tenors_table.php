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
        Schema::create('tenors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->integer('angsuran_ke');
            $table->decimal('angsuran_per_bulan', 16);
            $table->decimal('total_pembayaran', 16)->nullable();
            $table->integer('telat')->nullable();
            $table->decimal('denda', 12)->nullable();
            $table->date('tanggal_jatuh_tempo');
            $table->enum('status_pembayaran', ['lunas', 'belum lunas']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenors');
    }
};
