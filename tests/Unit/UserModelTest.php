<?php

namespace Tests\Unit;

use App\Models\UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{

    use RefreshDatabase;


    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_getUserByEmail()
    {
        $user = $this->createUser();

        $userObj = UserModel::getUserByEmail($user->email);

        $this->assertTrue(is_object($userObj));
    }
}
