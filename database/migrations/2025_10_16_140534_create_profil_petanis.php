<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_petanis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // user dengan role petani
            $table->string('nama_petani')->nullable();
            $table->string('varietas_bibit')->nullable();
            $table->decimal('luasan_lahan_total', 10, 2)->nullable(); // dalam ha atau m2 sesuai definisi
            $table->text('alamat')->nullable();
            $table->string('gmap_link')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_petani');
    }
};
