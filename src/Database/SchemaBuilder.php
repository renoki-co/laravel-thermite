<?php

namespace RenokiCo\LaravelThermite\Database;

use Closure;
use Illuminate\Database\Schema\PostgresBuilder;

class SchemaBuilder extends PostgresBuilder
{
    /**
     * Create a new command set with a Closure.
     *
     * @param  string  $table
     * @param  \Closure|null  $callback
     * @return \Illuminate\Database\Schema\Blueprint
     */
    protected function createBlueprint($table, Closure $callback = null)
    {
        $prefix = $this->connection->getConfig('prefix_indexes')
            ? $this->connection->getConfig('prefix')
            : '';

        return new Blueprint($table, $callback, $prefix);
    }
}
