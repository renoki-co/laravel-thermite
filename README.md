Laravel Thermite
================

![CI](https://github.com/renoki-co/laravel-thermite/workflows/CI/badge.svg?branch=master)
[![codecov](https://codecov.io/gh/renoki-co/laravel-thermite/branch/master/graph/badge.svg)](https://codecov.io/gh/renoki-co/laravel-thermite/branch/master)
[![StyleCI](https://github.styleci.io/repos/386672830/shield?branch=master)](https://github.styleci.io/repos/386672830)
[![Latest Stable Version](https://poser.pugx.org/renoki-co/laravel-thermite/v/stable)](https://packagist.org/packages/renoki-co/laravel-thermite)
[![Total Downloads](https://poser.pugx.org/renoki-co/laravel-thermite/downloads)](https://packagist.org/packages/renoki-co/laravel-thermite)
[![Monthly Downloads](https://poser.pugx.org/renoki-co/laravel-thermite/d/monthly)](https://packagist.org/packages/renoki-co/laravel-thermite)
[![License](https://poser.pugx.org/renoki-co/laravel-thermite/license)](https://packagist.org/packages/renoki-co/laravel-thermite)

Laravel Thermite is an extended PostgreSQL Laravel database driver to connect to a CockroachDB cluster.

## 🤝 Supporting

If you are using one or more Renoki Co. open-source packages in your production apps, in presentation demos, hobby projects, school projects or so, spread some kind words about our work or sponsor our work via Patreon. 📦

You will sometimes get exclusive content on tips about Laravel, AWS or Kubernetes on Patreon and some early-access to projects or packages.

[<img src="https://c5.patreon.com/external/logo/become_a_patron_button.png" height="41" width="175" />](https://www.patreon.com/bePatron?u=10965171)

## 🚀 Installation

You can install the package via composer:

```bash
composer require renoki-co/laravel-thermite
```

## 🙌 Usage

The driver is based on Postgres, most of the features from Laravel's first-party Postgres driver are available in CockroachDB.

```php
// config/database.php

return [
    // ...

    'connections' => [
        // ...

        'cockroachdb' => [
            'driver' => 'cockroachdb',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '26257'),
            'database' => env('DB_DATABASE', 'defaultdb'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

    ],
];
```

## ✨ Caveats

### Primary Keys are not incremental

Postgres supports incrementing keys, but since CockroachDB is based on a global multi-master architecture, having increments may lead to [transaction contention](https://www.cockroachlabs.com/docs/v21.1/sql-faqs#how-do-i-auto-generate-unique-row-ids-in-cockroachdb).

This way, this extended driver leverages you with two functions that you may call in your migrations to generate performant, unique IDs. The differences between the methods [can be found here](https://www.cockroachlabs.com/docs/v21.1/sql-faqs#what-are-the-differences-between-uuid-sequences-and-unique_rowid).

The `->id()` method got replaced to generate a random UUID as primary key with `gen_random_uuid()` instead of an incremental primary key. The downside is that is not orderable, opposed to `uniqueRowId()`:

```php
use RenokiCo\LaravelThermite\Database\Blueprint;

Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
});

class User extends Model
{
    // Make sure to set key type as string.
    protected $keyType = 'string';
}
```

With `uniqueRowId()`, it uses `unique_rowid()`-generated primary key. This is highly-orderable, being sequentially generated. The only minor downsides are the throttling upon insert, which are limited by one node.

```php
use RenokiCo\LaravelThermite\Database\Blueprint;

Schema::create('users', function (Blueprint $table) {
    $table->uniqueRowId();
    $table->string('name');
});

class User extends Model
{
    // Do not set the $keyType to string, as it is an integer.
}
```

### Foreign keys associated with Primary Keys

To represent the primary key constraints in other tables, like passing relational fields, consider using `->uuid()`:

```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
});

Schema::create('books', function (Blueprint $table) {
    $table->id();
    $table->uuid('user_id')->index();
    $table->string('name');
});

$book = $user->books()->create(['name' => 'The Great Gatsby']);
```

## Other caveats

Being based on Postgres, CockroachDB borrowed functionalities from its code. Consider [reading about CockroachDB-Postgres compatibilities](https://www.cockroachlabs.com/docs/v21.1/sql-feature-support.html) when it comes to schema capabilities and counter-patterns that may affect your implementation and [see further caveats that are CockroachDB-only](https://www.cockroachlabs.com/docs/v21.1/postgresql-compatibility.html).

## 🐛 Testing

``` bash
vendor/bin/phpunit
```

## 🤝 Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## 🔒  Security

If you discover any security related issues, please email alex@renoki.org instead of using the issue tracker.

## 🎉 Credits

- [Alex Renoki](https://github.com/rennokki)
- [All Contributors](../../contributors)
