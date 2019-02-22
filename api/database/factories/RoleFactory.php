<?php

use Faker\Generator as Faker;
use App\Models\Role;
use App\Models\Permission;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle
    ];
});

$factory->state(Role::class, 'withPermissions', [])
    ->afterCreatingState(Role::class, 'withPermissions', function ($role, $faker) {

        $permissions = factory(Permission::class, 3)
            ->create();

        $role->syncPermissions($permissions);
    });