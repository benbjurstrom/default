<?php

use Faker\Generator as Faker;
use App\Models\UserAgreement;

$factory->define(UserAgreement::class, function (Faker $faker) {
    return [
        'sha' => sha1('test'),
        'ip' => $faker->ipv4
    ];
});