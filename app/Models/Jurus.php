<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurus extends Model
{
    use HasFactory;
    protected $table = 'jurus';
    public $fillable = [
        'parent_id','name','ts_id','created_user'
    ];
}
