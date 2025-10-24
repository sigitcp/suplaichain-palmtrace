<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penimbangan_pks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penawaran_pengepul_id')->constrained('penawaran_pengepul_ke_pks')->onDelete('cascade');
            $table->date('tanggal_penerimaan')->nullable();
            $table->decimal('bruto', 12, 2)->nullable();
            $table->decimal('tara', 12, 2)->nullable();
            $table->decimal('netto', 12, 2)->nullable();
            $table->decimal('harga_beli_per_kg', 12, 2)->nullable();
            $table->decimal('potongan', 12, 2)->nullable();
            $table->decimal('total_transaksi', 14, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penimbangan_pks');
    }
};
