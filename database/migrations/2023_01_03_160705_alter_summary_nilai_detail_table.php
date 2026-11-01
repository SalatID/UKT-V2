<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSummaryNilaiDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('summary_nilai_detail', function (Blueprint $table) {
            $table->bigInteger('nilai')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('summary_nilai_detail', function (Blueprint $table) {
            $table->integer('nilai')->change();
        });
    }
}
