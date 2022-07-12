<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $table ='unit';
    public $fillable = [
        'name','tingkat','komwil_id','created_user'
    ];

    public function data_komwil()
    {
        return $this->hasOne(Komwil::class,'id','komwil_id');
    }
    public function newQuery($excludeDeleted = true) {
        return parent::newQuery($excludeDeleted)
            ->whereNull('unit.deleted_at');
    }
}
