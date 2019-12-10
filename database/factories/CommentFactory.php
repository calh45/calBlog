<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use App\Post;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(\App\Comment::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random(1)->first()->id,
        'post_id' => Post::all()->random(1)->first()->id,
        'content' => $faker->randomElement(["Great post", "I like this content", "Amazing", "10/10"]),

    ];
});
