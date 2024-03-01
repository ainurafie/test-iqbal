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
        Schema::create('targets', function (Blueprint $table) {
            $table->id('id_target');
            $table->unsignedBigInteger('id_rekening'); // Change to unsignedBigInteger
            $table->foreign('id_rekening')->references('id_rekening')->on('rekenings');
            $table->date('tahun');
            $table->string('nama_rekening', 255);
            $table->bigInteger('jumlah_target');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('targets');
    }
};
