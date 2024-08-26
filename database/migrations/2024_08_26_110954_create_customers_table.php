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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('kontrak_no')->unique();
            $table->string('client_name');
            $table->decimal('otr', 20);
            $table->decimal('dp', 20);
            $table->decimal('pokok_utang', 20);
            $table->integer('jangka_waktu');
            $table->decimal('bunga', 5);
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
