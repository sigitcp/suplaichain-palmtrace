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
        Schema::create('panens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lahan_id')->constrained('lahans')->onDelete('cascade');
            $table->date('tanggal_panen');
            $table->float('jumlah_pokok');
            $table->float('jumlah_perpokok');
            $table->enum('kualitas', ['baik', 'cukup', 'unggul'])->default('cukup')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panens');
    }
};
