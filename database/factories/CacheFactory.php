<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CacheModel;
use Faker\Generator as Faker;

$factory->define(CacheModel::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name
    ];
});
