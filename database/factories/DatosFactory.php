<?php

use Faker\Generator as Faker;

$factory->define(App\Datos::class, function (Faker $faker) {
    return [
        "nom" => $faker->name,
        "ap" => $faker->name,
        "am" => $faker->name,
        "condicion"=>$faker->randomElement(['1', '0']),
    ];
});
