<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Template;
use App\User;
use Faker\Generator as Faker;

$factory->define(Template::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'name' => $faker->name,
        'description' => $faker->realText,
        'photo' => $faker->imageUrl,
        'livedate' => '06/05/2003'
    ];
});
