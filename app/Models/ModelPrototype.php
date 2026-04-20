<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelPrototype extends Model
{
    use HasFactory;
    protected $table = 'modelpro';
    protected $fillable = [
        'model_name',
        'CreateAt',
        'UpdateAt',
    ];

}
