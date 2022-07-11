<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $table->id();
            $table->string('name',200);
            $table->dateTime('tgl_mulai');
            $table->dateTime('tgl_selesai');
            $table->string('lokasi',100);
            $table->string('penyelenggara',150);
            $table->string('komwil_id')->nullable();
            $table->string('gambar')->nullable();
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
        Schema::dropIfExists('event');
    }
}
