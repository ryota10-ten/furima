<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Profile extends Authenticatable
{
    protected $fillable = ['name','email','password','post','address','building','icon'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $table = 'profiles';

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function listings()
    {
        return $this->hasMany(Comment::class);
    }
}
