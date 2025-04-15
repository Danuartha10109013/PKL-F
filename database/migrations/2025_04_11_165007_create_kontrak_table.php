<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKontrakTable extends Migration
{
    public function up()
    {
        Schema::create('kontrak', function (Blueprint $table) {
            $table->id(); // Bigint unsigned primary key (id)
            $table->string('user_id'); // VARCHAR(255)
            $table->date('awal_kontrak');
            $table->date('akhir_kontrak');
            $table->string('periode'); // VARCHAR(255)
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('kontrak');
    }
}
