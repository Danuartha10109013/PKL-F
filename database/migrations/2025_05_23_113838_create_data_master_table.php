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
        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            $table->string('kategori')->nullable();
            $table->timestamps();
        });
        Schema::create('departement', function (Blueprint $table) {
            $table->id();
            $table->string('departement')->nullable();
            $table->timestamps();
        });
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->timestamps();
        });
        Schema::create('strategic', function (Blueprint $table) {
            $table->id();
            $table->string('strategic')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori');
        Schema::dropIfExists('strategic');
        Schema::dropIfExists('departement');
        Schema::dropIfExists('status');

    }
};
