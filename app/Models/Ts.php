<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ts extends Model
{
    use HasFactory;
    protected $table = 'ts';
    public $fillable =[
        'name','ts_code','created_user'
    ];
    public function newQuery($excludeDeleted = true) {
        return parent::newQuery($excludeDeleted)
            ->whereNull('deleted_at');
    }
}
