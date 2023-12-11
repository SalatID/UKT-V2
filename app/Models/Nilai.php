<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Nilai extends Model
{
    use HasFactory,LogsActivity;
    protected $table = 'nilai';
    public $fillable =[
        'jurus_id','nilai','kelompok_id','peserta_id','penguji_id','event_id','created_user'
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->useLogName($this->table);
    }
    public function data_jurus()
    {
        return $this->hasOne(Jurus::class,'id','jurus_id');
    }
    public function data_kelompok()
    {
        return $this->hasOne(Kelompok::class,'id','kelompok_id');
    }
    public function data_peserta()
    {
        return $this->hasOne(Peserta::class,'id','peserta_id');
    }
    public function data_penilai()
    {
        return $this->hasOne(Penilai::class,'id','penguji_id');
    }
    public function data_event()
    {
        return $this->hasOne(EventMaster::class,'id','event_id');
    }
}
