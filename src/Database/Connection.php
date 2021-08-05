<?php

namespace RenokiCo\LaravelThermite\Database;

use Illuminate\Database\PostgresConnection;
use Illuminate\Filesystem\Filesystem;
use RenokiCo\LaravelThermite\Exceptions\CockroachSchemaException;

class Connection extends PostgresConnection
{
    /**
     * Get the default query grammar instance.
     *
     * @return \RenokiCo\LaravelThermite\Database\QueryGrammar
     */
    protected function getDefaultQueryGrammar()
    {
        return $this->withTablePrefix(new QueryGrammar);
    }

    /**
     * Get a schema builder instance for the connection.
     *
     * @return \RenokiCo\LaravelThermite\Database\SchemaBuilder
     */
    public function getSchemaBuilder()
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }

        return new SchemaBuilder($this);
    }

    /**
     * Get the default schema grammar instance.
     *
     * @return \RenokiCo\LaravelThermite\Database\Schema\Grammars\Grammar
     */
    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new SchemaGrammar);
    }

    /**
     * Get the schema state for the connection.
     *
     * @param  \Illuminate\Filesystem\Filesystem|null  $files
     * @param  callable|null  $processFactory
     * @return \RenokiCo\LaravelThermite\Database\Schema\SchemaState
     */
    public function getSchemaState(Filesystem $files = null, callable $processFactory = null)
    {
        return new SchemaState($this, $files, $processFactory);
    }

    /**
     * Get the default post processor instance.
     *
     * @return \RenokiCo\LaravelThermite\Database\Query\Processors\Processor
     */
    protected function getDefaultPostProcessor()
    {
        return new Processor;
    }

    /**
     * Run a select statement against the database and returns a generator.
     *
     * @param  string  $query
     * @param  array  $bindings
     * @param  bool  $useReadPdo
     * @return \Generator
     */
    public function cursor($query, $bindings = [], $useReadPdo = true)
    {
        throw new CockroachSchemaException('CockroachDB does not support cursors.');
    }
}
