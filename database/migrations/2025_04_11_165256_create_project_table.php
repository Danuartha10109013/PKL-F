<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTable extends Migration
{
    public function up()
    {
        Schema::create('project', function (Blueprint $table) {
            $table->id(); // bigint unsigned
            $table->integer('kapro_id'); // int(11)
            $table->string('judul'); // varchar(255)
            $table->string('kode_project'); // varchar(255)
            $table->string('divisi'); // varchar(255)
            $table->string('kode_uk'); // varchar(255)
            $table->string('unit_kerja'); // varchar(255)
            $table->string('kategori'); // varchar(255)
            $table->string('sbu'); // varchar(255)
            $table->string('statusin'); // varchar(255)
            $table->string('deskripsi')->nullable(); // varchar(255)
            $table->string('pegawai_id')->nullable(); // varchar(255)
            $table->integer('status'); // int(11)
            $table->date('start')->nullable(); // date
            $table->date('end')->nullable(); // date
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('project');
    }
}
