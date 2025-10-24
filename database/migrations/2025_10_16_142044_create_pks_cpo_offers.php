<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pks_cpo_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pks_user_id')->constrained('users')->onDelete('cascade');
            $table->integer('kapasitas_tahunan_kg')->nullable();
            $table->decimal('palmitat', 8, 3)->nullable();
            $table->decimal('oleat', 8, 3)->nullable();
            $table->decimal('linoleat', 8, 3)->nullable();
            $table->decimal('stearat', 8, 3)->nullable();
            $table->decimal('myristat', 8, 3)->nullable();
            $table->decimal('trigliserida', 8, 3)->nullable();
            $table->decimal('ffa', 8, 3)->nullable(); // asam lemak bebas
            $table->decimal('fosfatida', 8, 3)->nullable();
            $table->decimal('karoten', 8, 3)->nullable();
            $table->string('dokumen_lab')->nullable();
            $table->enum('status', ['open','closed'])->default('open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pks_cpo_offers');
    }
};
