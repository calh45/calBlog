<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Activity;
use App\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Activity::class, function (Faker $faker) {
    return [
        'activity_type' => $faker->randomElement(["Comment", "Post"]),
        'content' => $faker->randomElement(["Great post", "I like this content", "Amazing", "10/10"]),
        'user_id' => User::all()->random(1)->first()->id,
        'post_id' => Post::all()->random(1)->first()->id,
    ];
});
