<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produksi_pks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pks_user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal_produksi');
            $table->decimal('jumlah_tbs_diolah', 14, 2)->nullable();
            $table->decimal('jumlah_cpo_kg', 14, 2);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produksi_pks');
    }
};
