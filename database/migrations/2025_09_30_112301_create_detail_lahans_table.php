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
        Schema::create('detail_lahans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lahan_id')->constrained('lahans')->onDelete('cascade');
            $table->string('penanggung_jawab')->nullable();
            $table->float('luas_kebun')->nullable();
            $table->string('sertifikat')->nullable();
            $table->text('file_geojson')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_lahans');
    }
};
