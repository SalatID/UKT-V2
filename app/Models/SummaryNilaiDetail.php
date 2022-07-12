<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummaryNilaiDetail extends Model
{
    use HasFactory;
    protected $table = 'summary_nilai_detail';
    public $fillable = [
        'summary_id','nama_jurus','jurus_id','nilai','peserta_id','kriteria','created_user','jurus_dinilai','total_jurus'
    ];

    public function criteria($nilai)
    {
       if($nilai <6 ){
           return 'KURANG';
       }
       if($nilai >=6 && $nilai <=8){
           return 'BAIK';
       }
       return 'AMAT BAIK';
    }
    public function averageParams($id)
    {
        return Jurus::where('parent_id',$id)->count();
    }
}
