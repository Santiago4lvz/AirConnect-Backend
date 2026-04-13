<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;  // ← Sin HasApiTokens

    protected $table = 'users';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'name', 
        'last_name', 
        'username', 
        'email', 
        'password', 
        'id_role'
    ];

    protected $hidden = [
        'password', 
        'remember_token'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }
}