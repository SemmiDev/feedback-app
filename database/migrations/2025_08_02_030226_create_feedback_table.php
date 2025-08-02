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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penceramah')->nullable();
            $table->string('nama_masjid')->nullable();
            $table->integer('imapp_id_penceramah')->nullable(); // referensi ke database imapp tabel penceramah
            $table->integer('imapp_id_masjid')->nullable(); // referensi ke database imapp tabel masjid
            $table->tinyInteger('relevansi_rating')->unsigned()->nullable();
            $table->tinyInteger('kejelasan_rating')->unsigned()->nullable();
            $table->tinyInteger('pemahaman_jamaah_rating')->unsigned()->nullable();
            $table->tinyInteger('kesesuaian_waktu_rating')->unsigned()->nullable();
            $table->tinyInteger('interaksi_jamaah_rating')->unsigned()->nullable();
            $table->text('saran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
