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
        Schema::create('kontrak', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->date('awal_kontrak');
            $table->date('akhir_kontrak');
            $table->string('periode');
            $table->string('no_bpjs')->nullable();
            $table->string('no_bpjstk')->nullable();
            $table->string('lokasi_bpjs')->nullable();
            $table->string('terdaftar_bpjstk')->nullable();
            $table->string('status_pegawai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontrak');
    }
};
