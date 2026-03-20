<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iot extends Model
{
    protected $fillable = [
        'device_name',
        'user_id',
        'status',
        'location',
        'co2_level',
        'temperature',
        'humidity',
    ];

    use HasFactory;
}
