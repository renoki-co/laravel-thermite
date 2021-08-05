<?php

namespace RenokiCo\LaravelThermite\Database;

use Illuminate\Database\Schema\Blueprint as BaseBlueprint;
use Illuminate\Support\Facades\DB;

class Blueprint extends BaseBlueprint
{
    /**
     * Create a new UUID column on the table that acts like a primary key.
     *
     * @param  string  $column
     * @return \Illuminate\Database\Schema\ColumnDefinition
     * @see https://www.cockroachlabs.com/docs/v21.1/sql-faqs#what-are-the-differences-between-uuid-sequences-and-unique_rowid
     */
    public function id($column = 'id')
    {
        return $this->uuid($column)
            ->primary()
            ->default(DB::raw('gen_random_uuid()'));
    }

    /**
     * Create a new Bytes V4 column on the table.
     *
     * @param  string  $column
     * @return \Illuminate\Database\Schema\ColumnDefinition
     * @see https://www.cockroachlabs.com/docs/v21.1/sql-faqs#what-are-the-differences-between-uuid-sequences-and-unique_rowid
     */
    public function bytesId($column = 'id')
    {
        return $this->addColumn('bytes', $column)
            ->primary()
            ->default(DB::raw('uuid_v4()'));
    }

    /**
     * Create a new INTEGER column on the table as unique row id.
     *
     * @param  string  $column
     * @return \Illuminate\Database\Schema\ColumnDefinition
     * @see https://www.cockroachlabs.com/docs/v21.1/sql-faqs#what-are-the-differences-between-uuid-sequences-and-unique_rowid
     */
    public function uniqueRowId($column = 'id')
    {
        return $this->integer($column, false, false)
            ->primary()
            ->default(DB::raw('unique_rowid()'));
    }
}
