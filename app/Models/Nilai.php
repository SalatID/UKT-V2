<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;
    protected $table = 'nilai';
    public $fillable =[
        'jurus_id','nilai','kelompok_id','peserta_id','penguji_id','event_id','created_user'
    ];
}
