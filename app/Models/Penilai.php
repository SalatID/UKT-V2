<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilai extends Model
{
    use HasFactory;
    protected $table = 'penilai';
    public $fillable = [
        'name','ts_id','komwil_id','event_id','created_user'
    ];

    public function data_komwil()
    {
        return $this->hasOne(Komwil::class,'id','komwil_id');
    }
    public function data_ts()
    {
        return $this->hasOne(Ts::class,'id','ts_id');
    }
    public function data_event()
    {
        return $this->hasOne(EventMaster::class,'id','event_id');
    }
    public function newQuery($excludeDeleted = true) {
        $query = parent::newQuery($excludeDeleted)
        ->whereNull('penilai.deleted_at');
        if((auth()->user()->role??'SPADM')!='SPADM')$query->where(['komwil.id'=>auth()->user()->komwil_id??'']);
        return $query;
    }
}
