<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualCertificate extends Model
{
    use HasFactory;
    protected $table='manual_certificate';

    protected $fillable = [
        'name', 
        'achievement'
    ];
}
