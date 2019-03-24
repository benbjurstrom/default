<?php

namespace Tests\Feature\Models;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAgreementRelationship()
    {
        $user = factory(User::class)
            ->states(['withAgreements'])
            ->create();

        $results = $user->agreements;
        $this->assertCount(2, $results);
    }
}
