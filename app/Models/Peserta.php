<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Peserta extends Model
{
    use HasFactory,LogsActivity;
    protected $table = 'peserta';
    public $fillable =[
        'no_peserta','name','ts_awal_id','tempat_lahir','tgl_lahir','komwil_id','unit_id','event_id','tingkat','created_user','foto'
    ];
    protected $casts = [
        'y' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->useLogName($this->table);
    }

    public function data_komwil()
    {
        return $this->hasOne(Komwil::class,'id','komwil_id');
    }
    public function data_unit()
    {
        return $this->hasOne(Unit::class,'id','unit_id');
    }
    public function data_ts()
    {
        return $this->hasOne(Ts::class,'id','ts_awal_id');
    }
    public function data_ts_akhir()
    {
        return $this->hasOne(Ts::class,'id','ts_akhir_id');
    }
    public function data_kelompok()
    {
        return $this->hasOne(Kelompok::class,'id','kelompok_id');
    }
    public function data_event()
    {
        return $this->hasOne(EventMaster::class,'id','event_id');
    }
    public function newQuery($excludeDeleted = true) {
        $query = parent::newQuery($excludeDeleted)
        ->whereNull('peserta.deleted_at');
        if((auth()->user()->role??'SPADM')!='SPADM')$query->where(['peserta.event_id'=>auth()->user()->event_id]);
        return $query;
    }
}
