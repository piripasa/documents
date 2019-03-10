<?php

$factory->define(App\Entities\Documents\Document::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});
