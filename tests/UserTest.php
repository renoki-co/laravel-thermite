<?php

namespace RenokiCo\LaravelThermite\Test;

use RenokiCo\LaravelThermite\Test\Models\User;

class UserTest extends TestCase
{
    public function test_user_store_and_retrieval()
    {
        $user = factory(User::class)->create();
        $fetchedUser = User::find($user->id);

        $this->assertTrue(
            $user->is($fetchedUser)
        );
    }
}
