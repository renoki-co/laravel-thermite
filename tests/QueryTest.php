<?php

namespace RenokiCo\LaravelThermite\Test;

use RenokiCo\LaravelThermite\Test\Models\Book;
use RenokiCo\LaravelThermite\Test\Models\User;

class QueryTest extends TestCase
{
    public function test_user_store_and_retrieval()
    {
        $user = factory(User::class)->create();
        $fetchedUser = User::find($user->id);

        $this->assertTrue(
            $user->is($fetchedUser)
        );
    }

    public function test_relations()
    {
        $user = factory(User::class)->create();
        $book = factory(Book::class)->create(['user_id' => $user]);

        $this->assertEquals(
            $user->books->first()->id,
            $book->id,
        );
    }
}
