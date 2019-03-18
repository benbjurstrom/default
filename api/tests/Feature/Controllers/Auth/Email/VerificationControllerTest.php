<?php

namespace Tests\Feature\Controllers\Auth\Email;

use App\Mail\EmailVerification;
use App\Models\User;
use App\Services\PasswordService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mail;

class VerificationControllerTest extends TestCase
{
    /**
     * POST
     */
    public function testStore()
    {
        Mail::fake();
        $user = factory(User::class)->create([
            'email_verified_at' => null
        ]);

        auth()->login($user);

        $this->getJson(route('auth.email.verify.index'))
            ->assertStatus(201);

        Mail::assertQueued(EmailVerification::class);
    }

    /**
     * PATCH
     */
    public function testVerifyWhereUnverified()
    {
        $ps = new PasswordService();

        $user = factory(User::class)->create([
            'email_verified_at' => null
        ]);
        $this->assertFalse($user->hasVerifiedEmail());

        auth()->login($user);
        $token = $ps->getEmailVerificationSignature($user);

        $this->patchJson(route('auth.email.verify.update', [
            'signature' => $token,
            'id'        => $user->id
        ]))
            ->assertStatus(200);

        $this->assertTrue($user->refresh()->hasVerifiedEmail());
    }
}