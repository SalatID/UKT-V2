<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komwil extends Model
{
    use HasFactory;
    protected $table = 'komwil';
    public $fillable = [
        'name','address','created_user'
    ];

    public function data_unit()
    {
        return $this->hasMany(Unit::class,'komwil_id','id');
    }

    public function newQuery($excludeDeleted = true) {
        return parent::newQuery($excludeDeleted)
            ->whereNull('deleted_at');
    }
}
