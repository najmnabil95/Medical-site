<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    protected $fillable = [
        'username',
        'password',
        'role',
        'name',
        'email',
        'phone',
        'active',
        'assigned_departments',
        'assigned_doctors',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'active' => 'boolean',
        'assigned_departments' => 'array',
        'assigned_doctors' => 'array',
    ];
}
