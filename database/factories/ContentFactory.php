<?php

use App\Models\Menu;
use App\Models\User;
use App\Models\Content;
use Faker\Generator as Faker;

$factory->define(Content::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'menu_id'  => function () {
            return factory(Menu::class)->create()->id;
        },
        'section_name' => $faker->text,
        'content' => $faker->text,
        'status' => true
    ];
});