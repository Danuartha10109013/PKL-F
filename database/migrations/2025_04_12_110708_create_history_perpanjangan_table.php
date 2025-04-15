<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('history_perpanjangan', function (Blueprint $table) {
            $table->id(); // bigint unsigned
            $table->integer('user_id'); // int(11)
            $table->string('jumlah_perpanjangan'); 
            $table->date('tanggal_perpanjangan'); 
            $table->date('awal'); 
            $table->date('akhir'); 
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('history_perpanjangan');
    }
};
