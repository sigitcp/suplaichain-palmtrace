<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualan_petani_ke_pengepul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petani_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pengepul_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pembukaan_penerimaan_id')->nullable()->constrained('pembukaan_penerimaan_pengepul')->onDelete('set null');
            $table->decimal('estimasi_tbs_kg', 12, 2)->nullable();
            // Apakah dijemput oleh pengepul (true) atau diantar oleh petani (false)
            $table->boolean('is_pickup')->default(false);

            // Jika DIANTAR oleh petani
            $table->date('tanggal_pengantaran')->nullable();
            $table->string('nomor_armada_pengantaran')->nullable();

            // Jika DIJEMPUT oleh pengepul
            $table->date('tanggal_penjemputan')->nullable();
            $table->string('nomor_armada_penjemputan')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'finish'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan_petani_ke_pengepul');
    }
};
