<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilai extends Model
{
    use HasFactory;
    protected $table = 'nilai';
    public $fillable = [
        'name','ts_id','komwil_id','event_id','created_user'
    ];
}
