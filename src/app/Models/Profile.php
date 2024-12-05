<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Profile extends Authenticatable
{
    protected $fillable = ['name','email','password','post','address','building'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $table = 'profiles';
}
