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

    public function data_ts()
    {
        return $this->hasOne(Ts::class,'id','ts_id');
    }
    public function data_parent()
    {
        return $this->hasOne(Jurus::class,'id','parent_id');
    }
    public function newQuery($excludeDeleted = true) {
        return parent::newQuery($excludeDeleted)
            ->whereNull('jurus.deleted_at');
    }
}
