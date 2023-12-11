<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Log;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SummaryNilaiDetail extends Model
{
    use HasFactory,LogsActivity;
    protected $table = 'summary_nilai_detail';
    public $fillable = [
        'summary_id','nama_jurus','jurus_id','nilai','peserta_id','kriteria','created_user','jurus_dinilai','total_jurus','event_id'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->useLogName($this->table);
    }

    public function criteria($nilai)
    {
        Log::info($nilai);
       if($nilai <6 ){
           return 'KURANG';
       }
       if($nilai >=6 && $nilai <=8){
           return 'BAIK';
       }
       return 'AMAT BAIK';
    }
    public function averageParams($id,$ts)
    {
        return Jurus::where('parent_id',$id)->where('ts_id','<=',$ts)->whereNull('deleted_at')->count();
    }
    public function data_peserta()
    {
        return $this->hasOne(Peserta::class,'id','peserta_id');
    }
}
