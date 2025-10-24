<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penimbangan_pengepul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penawaran_tbs_id')->nullable()->constrained('penawaran_tbs')->onDelete('cascade');
            $table->foreignId('penjualan_id')->nullable()->constrained('penjualan_petani_ke_pengepul')->onDelete('cascade');

            $table->decimal('tbs_baik_kg', 12, 2)->nullable();
            $table->decimal('harga_baik_per_kg', 12, 2)->nullable();
            $table->decimal('total_baik', 14, 2)->nullable();
            $table->decimal('tbs_reject_kg', 12, 2)->nullable();
            $table->decimal('harga_reject_per_kg', 12, 2)->nullable();
            $table->decimal('total_reject', 14, 2)->nullable();
            $table->timestamp('tanggal_penimbangan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penimbangan_pengepul');
    }
};
