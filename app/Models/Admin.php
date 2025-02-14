<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $guarded = [];
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $guard_name = 'admin';
}
