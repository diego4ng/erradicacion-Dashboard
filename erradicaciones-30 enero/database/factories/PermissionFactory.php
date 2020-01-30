<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Models\Permission;

$factory->define(Permission::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'slug' => $faker->word,
    ];
});
