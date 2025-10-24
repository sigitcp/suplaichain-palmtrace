<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembukaan_penerimaan_pengepul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengepul_user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('harga_per_kg', 12, 2);
            $table->integer('kapasitas_kg')->nullable();
            $table->text('terms')->nullable();
            $table->enum('status', ['open','closed'])->default('open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembukaan_penerimaan_pengepul');
    }
};
