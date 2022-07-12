<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSummaryNilaiDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('summary_nilai_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('summary_id')->unsigned();
            $table->string('nama_jurus',150);
            $table->integer('jurus_id')->unsigned();
            $table->integer('jurus_dinilai')->unsigned();
            $table->integer('total_jurus')->unsigned();
            $table->float('nilai',3,2)->unsigned();
            $table->integer('peserta_id')->unsigned();
            $table->string('kriteria',10);
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
        Schema::dropIfExists('summary_nilai_detail');
    }
}
