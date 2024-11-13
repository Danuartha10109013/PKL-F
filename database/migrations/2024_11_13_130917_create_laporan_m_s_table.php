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
        Schema::create('laporan_m_s', function (Blueprint $table) {
            $table->id();
            $table->string('project_id');
            $table->string('pencapaian')->nullable();
            $table->text('ringkasan')->nullable();
            $table->string('hasil')->nullable();
            $table->string('kendala')->nullable();
            $table->string('solusi')->nullable();
            $table->string('rencana')->nullable();
            $table->string('inisiatif_tambahan')->nullable();
            $table->string('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_m_s');
    }
};
