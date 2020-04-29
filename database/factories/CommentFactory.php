<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use App\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random(),
        'post_id' => Post::all()->random(),
        'body' => $faker->text(10)
    ];
});
