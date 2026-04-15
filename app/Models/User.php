<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 
        'username', 
        'nisn',        // Tambahkan NISN
        'email', 
        'password',
        'role', 
        'kelas', 
        'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password'  => 'hashed',
        'is_active' => 'boolean',
    ];

    public function isAdmin(): bool 
    { 
        return $this->role === 'admin'; 
    }
    
    public function isUser(): bool  
    { 
        return $this->role === 'user'; 
    }

    public function aspirasi()
    {
        return $this->hasMany(Aspirasi::class, 'user_id');
    }
}