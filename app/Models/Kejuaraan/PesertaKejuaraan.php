<?php

namespace App\Models\Kejuaraan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class PesertaKejuaraan extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'peserta_kejuaraan';

    public static function nama_kontingen()
    {
        return self::select('nama_kontingen')->groupBy('nama_kontingen')->orderBy('nama_kontingen')->get();
    }
    public static function asal_kontingen()
    {
        return self::select('asal_kontingen')->groupBy('asal_kontingen')->orderBy('asal_kontingen')->get();
    }
    public static function kelas_sekolah()
    {
        return self::select('kelas_sekolah')->groupBy('kelas_sekolah')->orderBy('kelas_sekolah')->get();
    }
    public static function kategori_usia()
    {
        return self::select('kategori_usia')->groupBy('kategori_usia')->orderBy('kategori_usia')->get();
    }
    public static function validate_nik($nik)
    {
        if(strlen($nik)<16){
            return 'NIK kurang dari 16';
        }
        if(strlen($nik)>16){
            return 'NIK lebih dari 16';
        }
        if(substr($nik,-3)=='000'){
            return 'NIK tidak boleh diakhiri 000';
        }
        return '';
    }
    public function weight()
    {
        return $this->hasOne(Weight::class,'id','id_weight');
    }
}
