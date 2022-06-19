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

    public function data_peserta()
    {
        return $this->hasMany(Peserta::class,'kelompok_id','id');
    }
    public function data_ts()
    {
        return $this->hasOne(Ts::class,'id','ts_id');
    }
}
