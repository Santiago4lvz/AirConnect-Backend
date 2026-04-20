<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use app\Http\Controllers\PrototypeController;

class Prototype extends Model
{
    use HasFactory;

    protected $table = 'prototype';

    protected $fillable = [
        'user_id',
        'name',
        'temperature',
        'humidity',
        'dust_level',
    ];

    protected $casts = [
        'temperature' => 'float',
        'humidity' => 'float',
        'dust_level' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
