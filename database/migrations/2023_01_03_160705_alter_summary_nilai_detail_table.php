<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterSummaryNilaiDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * Mengubah tipe kolom `nilai` menjadi BIGINT tanpa Doctrine DBAL
     * (DBAL tidak tersedia di server production).
     *
     * @return void
     */
    public function up()
    {
        $column = $this->getNilaiColumn();

        if ($column && strtolower($column->data_type) !== 'bigint') {
            $nullable = strtoupper($column->is_nullable) === 'YES' ? 'NULL' : 'NOT NULL';

            DB::statement("ALTER TABLE `summary_nilai_detail` MODIFY `nilai` BIGINT {$nullable}");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $column = $this->getNilaiColumn();

        if ($column && strtolower($column->data_type) === 'bigint') {
            $nullable = strtoupper($column->is_nullable) === 'YES' ? 'NULL' : 'NOT NULL';

            DB::statement("ALTER TABLE `summary_nilai_detail` MODIFY `nilai` INT {$nullable}");
        }
    }

    /**
     * Ambil definisi kolom `nilai` langsung dari information_schema.
     *
     * @return object|null
     */
    private function getNilaiColumn()
    {
        return DB::selectOne(
            'SELECT DATA_TYPE AS data_type, IS_NULLABLE AS is_nullable
             FROM information_schema.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = ?
               AND COLUMN_NAME = ?',
            ['summary_nilai_detail', 'nilai']
        );
    }
}
