<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penawaran_pengepul_ke_pks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengepul_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pks_id')->constrained('users')->onDelete('cascade');
            $table->decimal('estimasi_tbs_kg', 12, 2)->nullable();
            $table->string('nomor_armada')->nullable();
            $table->string('nama_supir')->nullable();
            $table->string('varietas')->nullable();
            $table->json('foto_tbs')->nullable(); // array foto (min 1, max 3) disimpan path
            $table->date('tanggal_pengantaran')->nullable(); // tambahan kolom tanggal pengantaran
            $table->enum('status', ['pending','accepted','rejected','completed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penawaran_pengepul_ke_pks');
    }
};
