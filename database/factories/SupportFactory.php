<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Support;
use Faker\Generator as Faker;

$factory->define(Support::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'subject' => 'subject',
        'message' => $faker->text
    ];
});
