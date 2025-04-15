<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanTable extends Migration
{
    public function up()
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id(); // bigint unsigned primary key
            $table->string('project_id'); // varchar(255)
            $table->integer('user_id'); // int(11)
            $table->string('pencapaian')->nullable();
            $table->text('ringkasan')->nullable();
            $table->string('hasil')->nullable();
            $table->string('kendala')->nullable();
            $table->string('solusi')->nullable();
            $table->string('rencana')->nullable();
            $table->string('inisiatif_tambahan')->nullable();
            $table->string('catatan')->nullable();
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan');
    }
}
