<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Apps;
use App\Model\Questions;
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

$factory->define(Questions::class, function (Faker $faker) {
    return [
        'app_id'    => Apps::all()->random()->id,
        'details'   => $faker->text('100'),
        'a'         => $faker->text('20'),
        'b'         => $faker->text('20'),
        'c'         => $faker->text('20'),
        'd'         => $faker->text('20'),
        'answer'    => $faker->regexify('[a-d]{1}'),
    ];
});
