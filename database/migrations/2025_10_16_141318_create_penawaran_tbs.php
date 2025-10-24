<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penawaran_tbs', function (Blueprint $table) {
            $table->id();

            // Relasi ke petani
            $table->foreignId('petani_user_id')->constrained('users')->onDelete('cascade');

            // Relasi ke lahan
            $table->foreignId('lahan_id')->nullable()->constrained('lahans')->onDelete('set null');

            // Estimasi jumlah TBS
            $table->decimal('estimasi_tbs_kg', 12, 2);

            // Status penawaran
            $table->enum('status', ['open', 'reserved', 'finish',])->default('open');

            // Pengepul yang memesan (jika ada)
            $table->foreignId('reserved_by_pengepul_id')->nullable()->constrained('users')->onDelete('set null');

            // Apakah dijemput oleh pengepul (true) atau diantar oleh petani (false)
            $table->boolean('is_pickup')->default(false);

            // Jika DIANTAR oleh petani
            $table->date('tanggal_pengantaran')->nullable();
            $table->string('nomor_armada_pengantaran')->nullable();

            // Jika DIJEMPUT oleh pengepul
            $table->date('tanggal_penjemputan')->nullable();
            $table->string('nomor_armada_penjemputan')->nullable();

            // Expired time dari penawaran
            $table->timestamp('expired_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penawaran_tbs');
    }
};
