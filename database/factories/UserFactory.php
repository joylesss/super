<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Users;
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

$factory->define(Users::class, function (Faker $faker) {
    return [
        'name'      => 'Joyless',#$faker->name,
        'phone'     => '0368185092',
        'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'role'      => 1,
        'fb_id'     => '25251325',
        'fb_email'  => 'bibiphanth11@gmail.com',#$faker->unique()->safeEmail,
        'fb_url'    => '',
    ];

    /*return [
        'name'      => $faker->unique()->name,
        'phone'     => $faker->unique()->phoneNumber,
        'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'role'      => 0,
        'fb_id'     => $faker->unique()->creditCardNumber,
        'fb_email'  => $faker->unique()->safeEmail,
        'fb_url'    => $faker->url,
    ];*/
});
