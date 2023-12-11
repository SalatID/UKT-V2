<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Komwil extends Model
{
    use HasFactory,LogsActivity;
    protected $table = 'komwil';
    public $fillable = [
        'name','address','created_user'
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->useLogName($this->table);
    }
    public function data_unit()
    {
        return $this->hasMany(Unit::class,'komwil_id','id');
    }

    public function newQuery($excludeDeleted = true) {
        $query = parent::newQuery($excludeDeleted)
        ->whereNull('komwil.deleted_at');
        if((auth()->user()->role??'SPADM')!='SPADM')$query->where(['komwil.id'=>auth()->user()->komwil_id??'']);
        return $query;
    }
}
