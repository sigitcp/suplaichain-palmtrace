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
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjualan_id')->constrained('penjualans')->onDelete('cascade');
            $table->foreignId('pengepul_id')->constrained('users')->onDelete('cascade');
            $table->string('nomor_armada')->nullable();
            $table->dateTime('tanggal_jemput')->nullable();
            $table->float('jumlah_kg')->nullable();
            $table->float('harga_perkg')->nullable();
            $table->float('total_harga')->nullable();
            $table->enum('kualitas', ['sangat baik', 'baik', 'cukup', 'kurang'])->nullable();
            $table->enum('status', ['on_progress', 'selesai'])->default('on_progress');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};
