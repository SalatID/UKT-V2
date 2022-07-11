<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            $table->string('no_peserta',6);
            $table->string('name',200);
            $table->integer('ts_awal_id')->unsigned();
            $table->integer('ts_akhir_id')->unsigned()->nullable();
            $table->string('tempat_lahir',100);
            $table->string('tgl_lahir',20);
            $table->integer('komwil_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->integer('kelompok_id')->unsigned()->nullable();
            $table->integer('event_id')->unsigned();
            $table->string('tingkat',20);
            $table->string('foto')->nullable();
            $table->integer('created_user');
            $table->integer('updated_user')->nullable();
            $table->integer('deleted_user')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peserta');
    }
}
