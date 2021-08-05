<?php

namespace RenokiCo\LaravelThermite\Test;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RenokiCo\LaravelThermite\Database\SchemaGrammar;

class SchemaTest extends TestCase
{
    public function test_schema_creation_with_uuid()
    {
        Schema::create('schema_test', function (Blueprint $table) {
            $table->id();
            $table->string('some_field');
            // dd($table->toSql(DB::connection('cockroachdb'), new SchemaGrammar));
        });

        DB::table('schema_test')->insert(['some_field' => 'yes']);

        $result = DB::table('schema_test')->first();

        $this->assertNotNull($result->id);
        $this->assertEquals('yes', $result->some_field);
    }

    public function test_schema_creation_with_binary_uuid()
    {
        Schema::create('schema_test', function (Blueprint $table) {
            $table->bytesId();
            $table->string('some_field');
            // dd($table->toSql(DB::connection('cockroachdb'), new SchemaGrammar));
        });

        DB::table('schema_test')->insert(['some_field' => 'yes']);

        $result = DB::table('schema_test')->first();

        $this->assertTrue(is_resource($result->id));
        $this->assertEquals('yes', $result->some_field);
    }

    public function test_schema_creation_with_row_id()
    {
        Schema::create('schema_test', function (Blueprint $table) {
            $table->uniqueRowId();
            $table->string('some_field');
            // dd($table->toSql(DB::connection('cockroachdb'), new SchemaGrammar));
        });

        DB::table('schema_test')->insert(['some_field' => 'yes']);

        $result = DB::table('schema_test')->first();

        $this->assertNotNull($result->id);
        $this->assertEquals('yes', $result->some_field);
    }
}
