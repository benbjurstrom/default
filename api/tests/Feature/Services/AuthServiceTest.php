<?php

namespace Tests\Feature\Services;

use App\Models\User;
use App\Services\AuthService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthServiceTest extends TestCase
{
    function testValidateAuthenticatedUsersPassword(){
        $password = str_random(10);
        $user = factory(User::class)->create(['password' => bcrypt($password)]);

        auth()->login($user);
        $user = (new AuthService())->validateAuthenticatedUsersPassword($password);
        $this->assertNotNull($user);
    }
}
