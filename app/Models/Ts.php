<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Ts extends Model
{
    use HasFactory,LogsActivity;
    protected $table = 'ts';
    public $fillable =[
        'name','ts_code','created_user','id','ts_before','ts_next'
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->useLogName($this->table);
    }
    public function newQuery($excludeDeleted = true) {
        return parent::newQuery($excludeDeleted)
            ->whereNull('ts.deleted_at');
    }
}
