<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Users;
use App\Model\Apps;
use App\Model\Scores;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Scores::class, function (Faker $faker) {
    return [
        'user_id'       => Users::all()->random()->id,
        'app_id'        => Apps::all()->random()->id,
        'point'         => $faker->randomNumber(3),
        'play_times'    => $faker->randomNumber(3),
    ];
});
