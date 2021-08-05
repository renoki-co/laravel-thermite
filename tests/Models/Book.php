<?php

namespace RenokiCo\LaravelThermite\Test\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $keyType = 'string';

    protected $fillable = [
        'user_id', 'name',
    ];
}
