<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $guard = "admin";

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'phone'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
