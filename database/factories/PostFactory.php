<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Post;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Post::class, function (Faker $faker) {
    $title = $faker->sentence(5);

    return [
        'title' => $title,
        'alias' => Str::slug($title),
        'body' => $faker->text(1000),
        'user_id' => User::all()->random()
    ];
});
