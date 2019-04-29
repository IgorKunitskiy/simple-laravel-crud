<?php

use Faker\Generator as Faker;

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

$factory->define(App\Project::class, function (Faker $faker) {

    $statuses = ['planned', 'running', 'on hold', 'finished', 'cancel'];

    return [
        'name' => $faker->realText(20),
        'description' => $faker->realText(200),
        'status' => $statuses[mt_rand(0, 4)],
        // 'deleted' => mt_rand(0, 1),
    ];
});
