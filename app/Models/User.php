<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'fullname',
        'username',
        'email',
        'password',
        'phone',
        'address',
        'gender',
        'birthday',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'date',
        'gender' => 'integer',
        'role' => 'integer',
        'status' => 'integer',
    ];
}