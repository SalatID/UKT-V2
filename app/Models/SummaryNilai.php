<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummaryNilai extends Model
{
    use HasFactory;
    protected $table = 'summary_nilai';
    public $fillable = [
        'event_id','peserta_id','rata_rata','kriteria','total','created_user','no_sertifikat'
    ];

    public function data_detail()
    {
        return $this->hasMany(SummaryNilaiDetail::class,'summary_id','id');
    }

    public function data_peserta()
    {
        return $this->hasOne(Peserta::class,'id','peserta_id');
    }
}
