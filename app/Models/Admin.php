<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Concerns\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Admin extends Authenticatable
{
    use HasFactory,Notifiable,HasApiTokens,HasRoles;
    public $rememberTokenName = null;
    protected $fillable=
    [
        'name','email','password','phone_number','super_admin','status',
    ];
}
