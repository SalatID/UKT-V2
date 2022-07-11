<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory;
    protected $table = 'kelompok';
    public $fillable =[
        'name','event_id','ts_id','penilai_id','created_user'
    ];

    public function newQuery($excludeDeleted = true) {
        $query = parent::newQuery($excludeDeleted)
        ->whereNull('deleted_at');
        if(auth()->user()->role!='SPADM')$query->where(['event_id'=>auth()->user()->event_id,'komwil_id'=>auth()->user()->komwil_id]);
        return $query;
    }
    public function data_peserta()
    {
        return $this->hasMany(Peserta::class,'kelompok_id','id');
    }
    public function data_ts()
    {
        return $this->hasOne(Ts::class,'id','ts_id');
    }
    public function data_event()
    {
        return $this->hasOne(EventMaster::class,'id','event_id');
    }
}
