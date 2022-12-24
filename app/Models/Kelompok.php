<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Kelompok extends Model
{
    use HasFactory,LogsActivity;
    protected $table = 'kelompok';
    public $fillable =[
        'name','event_id','ts_id','penilai_id','created_user'
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->useLogName($this->table);
    }
    public function newQuery($excludeDeleted = true) {
        $query = parent::newQuery($excludeDeleted)
        ->whereNull('kelompok.deleted_at');
        if((auth()->user()->role??'SPADM')!='SPADM')$query->where(['kelompok.event_id'=>auth()->user()->event_id,'kelompok.komwil_id'=>auth()->user()->komwil_id]);
        return $query;
    }
    public function data_peserta()
    {
        return $this->hasMany(Peserta::class,'kelompok_id','id')->orderBy('no_peserta')->orderBy('name');
    }
    public function data_ts()
    {
        return $this->hasOne(Ts::class,'id','ts_id');
    }
    public function data_event()
    {
        return $this->hasOne(EventMaster::class,'id','event_id');
    }
    public function data_penilai()
    {
        return $this->hasOne(Penilai::class,'id','penilai_id');
    }
}
