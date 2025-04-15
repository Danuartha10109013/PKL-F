<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // bigint unsigned
            $table->string('username');
            $table->string('name');
            $table->string('role');
            $table->string('active');
            $table->string('no_pegawai');
            $table->string('profile')->nullable();
            $table->string('email');
            $table->string('personel_number')->nullable();
            $table->integer('status_data')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('posisi')->nullable();
            $table->string('gender')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('no_ktp')->nullable();
            $table->string('phone')->nullable();
            $table->string('agama')->nullable();
            $table->string('kawin')->nullable();
            $table->string('tanggungan')->nullable();
            $table->string('npwp')->nullable();
            $table->string('alamat')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('no_bpjs')->nullable();
            $table->string('no_bpjstk')->nullable();
            $table->string('lokasi_bpjs')->nullable();
            $table->string('terdaftar_bpjstk')->nullable();
            $table->string('status_pegawai')->nullable();
            $table->rememberToken(); // varchar(100) nullable
            $table->timestamps(); // created_at & updated_at
            $table->string('project_id')->nullable();
            $table->integer('deleteing')->default(0); // note: original column name might be 'deleting'
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
