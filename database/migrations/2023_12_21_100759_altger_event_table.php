<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AltgerEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event', function (Blueprint $table) {
            if (!Schema::hasColumn('event', 'blangko_belakang')) {
                $table->string('blangko_belakang')->nullable();
            }
            if (!Schema::hasColumn('event', 'orientation')) {
                $table->string('orientation')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event', function (Blueprint $table) {
            if (Schema::hasColumn('event', 'blangko_belakang')) {
                $table->dropColumn('blangko_belakang');
            }
            if (Schema::hasColumn('event', 'orientation')) {
                $table->dropColumn('orientation');
            }
        });
    }
}
