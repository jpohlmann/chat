<?php
use Faker\Generator as Faker;

$factory->define(App\Http\Models\Message::class, function (Faker $faker) {
    return [
        'message'    => $faker->text,
        'sender_id'  => \App\Http\Models\User::all()->random()->id,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
});