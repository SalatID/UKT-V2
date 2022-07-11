<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;
    protected $table = 'peserta';
    public $fillable =[
        'no_peserta','name','ts_awal_id','tempat_lahir','tgl_lahir','komwil_id','unit_id','event_id','tingkat','created_user','foto'
    ];

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
        ->whereNull('deleted_at');
        if(auth()->user()->role!='SPADM')$query->where(['event_id'=>auth()->user()->event_id]);
        return $query;
    }
}
