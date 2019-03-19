<?php

namespace Tests\Feature\Controllers\Auth\Password;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Hash;

class ChangeControllerTest extends TestCase
{
    /**
     * PATCH
     */
    public function testUpdate()
    {
        $password_old = str_random(10);
        $password_new = str_random(10);

        $user = factory(User::class)->create(['password' => bcrypt($password_old)]);
        auth()->login($user);

        $this->assertFalse(Hash::check($password_new, $user->password));

        $this->patchJson(route('auth.password.change.update'), [
                'password' => $password_old,
                'password_new' => $password_new,
                'password_new_confirmation' => $password_new
            ]
        )->assertStatus(200);

        $this->assertTrue(Hash::check($password_new, $user->fresh()->password));
    }
}
