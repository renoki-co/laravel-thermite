<?php

use Illuminate\Support\Str;

$factory->define(\RenokiCo\LaravelThermite\Test\Models\Book::class, function () {
    return [
        'name' => 'Name'.Str::random(5),
    ];
});
