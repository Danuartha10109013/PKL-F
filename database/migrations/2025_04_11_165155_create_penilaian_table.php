<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianTable extends Migration
{
    public function up()
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id(); // bigint unsigned primary key
            $table->string('user_id'); // VARCHAR(255)
            $table->string('project_id'); // VARCHAR(255)
            $table->string('hasil_kerja'); // VARCHAR(255)
            $table->string('kualitas_kerja'); // VARCHAR(255)
            $table->string('kepatuhan_sop'); // VARCHAR(255)
            $table->float('total'); // FLOAT
            $table->string('keterangan')->nullable(); // VARCHAR(255), nullable
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('penilaian');
    }
}
