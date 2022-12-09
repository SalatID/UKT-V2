<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class SummaryNilai extends Model
{
    use HasFactory,LogsActivity;
    protected $table = 'summary_nilai';
    public $fillable = [
        'event_id','peserta_id','rata_rata','kriteria','total','created_user','no_sertifikat'
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->useLogName($this->table);
    }
    public function data_detail()
    {
        return $this->hasMany(SummaryNilaiDetail::class,'summary_id','id');
    }

    public function data_peserta()
    {
        return $this->hasOne(Peserta::class,'id','peserta_id');
    }
}
