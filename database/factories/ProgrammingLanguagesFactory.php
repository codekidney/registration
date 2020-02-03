<?php

/** @var Factory $factory */

use App\Faker\FakerProvider;
use App\ProgrammingLanguages;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(ProgrammingLanguages::class, function (Faker $faker) {
    $faker->addProvider(new FakerProvider($faker));
    return [
        'name' => $faker->unique()->programmingLanguage
    ];
});
