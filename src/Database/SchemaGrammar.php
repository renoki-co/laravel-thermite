<?php

namespace RenokiCo\LaravelThermite\Database;

use Illuminate\Database\Schema\Grammars\PostgresGrammar;
use Illuminate\Support\Fluent;

class SchemaGrammar extends PostgresGrammar
{
    /**
     * Create the column definition for a big integer type.
     *
     * @param  \Illuminate\Support\Fluent  $column
     * @return string
     */
    protected function typeBytes(Fluent $column)
    {
        return $this->generatableColumn('bytes', $column);
    }
}
