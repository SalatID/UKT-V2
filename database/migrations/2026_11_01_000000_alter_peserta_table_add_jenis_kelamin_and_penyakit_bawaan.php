<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPesertaTableAddJenisKelaminAndPenyakitBawaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peserta', function (Blueprint $table) {
            if (!Schema::hasColumn('peserta', 'jenis_kelamin')) {
                $table->string('jenis_kelamin', 10)->nullable()->after('name');
            }
            if (!Schema::hasColumn('peserta', 'penyakit_bawaan')) {
                $table->string('penyakit_bawaan', 255)->nullable()->after('jenis_kelamin');
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
        Schema::table('peserta', function (Blueprint $table) {
            if (Schema::hasColumn('peserta', 'jenis_kelamin')) {
                $table->dropColumn('jenis_kelamin');
            }
            if (Schema::hasColumn('peserta', 'penyakit_bawaan')) {
                $table->dropColumn('penyakit_bawaan');
            }
        });
    }
}
