<?php

namespace Tests\Feature;

use App\Models\UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use RefreshDatabase;

    public function test_user_can_register()
    {
        $user                          = UserModel::factory()->make()->toArray();
        $user['password']              = "123";
        $user["password_confirmation"] = $user['password'];

        $response = $this->postJson(route('user.register'), $user);

        $response->assertCreated();
        $this->assertDatabaseHas('users', [
            'email' => $user["email"]
        ]);
    }

    public function test_user_can_login()
    {
        $user = $this->createUser();

        $response = $this->postJson(route('user.login'), [
            "email"    => $user->email,
            "password" => "123"
        ]);

        $response->assertOk();

        $this->assertArrayHasKey('token', $response->json()["data"]);
    }

    public function test_user_login_invalid_email()
    {
        $response = $this->postJson(route('user.login'), [
            "email"    => "a@a.com",
            "password" => "123"
        ]);

        $response->assertUnauthorized();
    }

    public function test_user_login_invalid_password()
    {
        $user = $this->createUser();

        $response = $this->postJson(route('user.login'), [
            "email"    => $user->email,
            "password" => "123456"
        ]);

        $response->assertUnauthorized();
    }

}
