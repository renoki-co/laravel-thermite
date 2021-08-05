<?php

namespace RenokiCo\LaravelThermite\Test\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $keyType = 'string';

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
