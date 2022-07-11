<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'event';
    public $fillable =[
        'name','tgl_mulai','tgl_selesai','lokasi','penyelenggara','komwil_id','gambar','created_user'
    ];
    public function newQuery($excludeDeleted = true) {
        return parent::newQuery($excludeDeleted)
            ->whereNull('deleted_at');
    }
    public function data_komwil()
    {
        return $this->hasOne(Komwil::class,'id','komwil_id');
    }
}
