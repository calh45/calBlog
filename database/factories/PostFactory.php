<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use App\Post;
use Illuminate\Support\Str;

;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'userId' => User::all()->random(1)->first()->id,
        'postType' => "Text",
        'content' => $faker->randomElement(["Web Apps is great", "My day was good", "What is the meaning of life?"]),
        'image_id' => null
    ];
});
