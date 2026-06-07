<?php

namespace App\Models;

// 1. تأكد بلي هاد السطر كاين
use Laravel\Sanctum\HasApiTokens; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // 2. تأكد بلي زدتي HasApiTokens هنا مع الخرين
    use HasApiTokens, HasFactory, Notifiable;

  protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'abonnement', // زدنا هادي
        'statut',     // وزدنا هادي
        'certificat'  // وزدنا هادي
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}