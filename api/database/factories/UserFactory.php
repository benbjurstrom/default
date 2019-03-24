<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Models\User;
use App\Models\Role;
use App\Models\UserAgreement;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => Str::random(10),
    ];
});


$factory->state(User::class, 'withRoles', [])
    ->afterCreatingState(User::class, 'withRoles', function ($user, $faker) {

        $roles = factory(Role::class, 3)
            ->states(['withPermissions'])
            ->create();

        $roles->each(function($role) use ($user) {
            $user->assignRole($role);
        });

    });

$factory->state(User::class, 'withAgreements', [])
    ->afterCreatingState(User::class, 'withAgreements', function ($user, $faker) {

        // terms agreement
        factory(UserAgreement::class)
            ->create([
                'user_id' => $user->id,
                'sha' => '99be19567be21c4d1034baa834432fe5f2306afe'
            ]);

        // privacy agreement
        factory(UserAgreement::class)
            ->create([
                'user_id' => $user->id,
                'sha' => 'fb16d59f04146c120200640ab11f04abc651ed1f'
            ]);

    });