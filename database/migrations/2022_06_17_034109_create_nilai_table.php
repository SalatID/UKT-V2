<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->index(['jurus_id', 'kelompok_id','peserta_id','event_id'],'unique');
            $table->id();
            $table->integer('jurus_id')->unsigned();
            $table->integer('nilai')->unsigned();
            $table->integer('kelompok_id')->unsigned();
            $table->integer('peserta_id')->unsigned();
            $table->integer('penguji_id')->unsigned();
            $table->integer('event_id')->unsigned();
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
        Schema::dropIfExists('nilai');
    }
}
