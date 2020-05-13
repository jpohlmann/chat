<?php
use Faker\Generator as Faker;

$factory->define(App\Http\Models\User::class, function (Faker $faker) {
    return [
        'name'       => $faker->name,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
});