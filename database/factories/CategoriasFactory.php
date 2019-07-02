<?php

use Faker\Generator as Faker;

$factory->define(App\Categorias::class, function (Faker $faker) {
    return [
        "nombre" => $faker->name,
        "descripcion" => $faker->sentence,
        "condicion"=>$faker->randomElement(['1', '0']),
    ];
});
