<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ts', function (Blueprint $table) {
            $table->id();
            $table->string('name',200);
            $table->string('ts_code',5);
            $table->integer('ts_next')->unsigned()->nullable();
            $table->integer('ts_before')->unsigned()->nullable();
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
        Schema::dropIfExists('ts');
    }
}
