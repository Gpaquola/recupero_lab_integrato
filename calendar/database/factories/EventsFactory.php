<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Event::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'note' => $faker->sentence,
        'priority' => rand(1, 9),
        'begin' => $faker->dateTime,
        'end' => $faker->dateTime,
        'created_at' => now()
    ];
});
