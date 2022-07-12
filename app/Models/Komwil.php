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
        $query = parent::newQuery($excludeDeleted)
        ->whereNull('komwil.deleted_at');
        if((auth()->user()->role??'')!='SPADM')$query->where(['komwil.id'=>auth()->user()->komwil_id??'']);
        return $query;
    }
}
