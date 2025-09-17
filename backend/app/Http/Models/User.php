<?php

namespace App\Http\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use Notifiable, HasApiTokens;
    
    protected $fillable = ['id', 'name', 'email', 'password'];
    
    protected $hidden = ['password', 'remember_token'];
    
    protected $casts = ['email_verified_at' => 'datetime'];

    public function user_details() {
        return $this->hasOne(UserDetail::class);
    }
}
