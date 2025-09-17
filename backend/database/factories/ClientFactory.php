<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Http\Models\Clients;
use Faker\Generator as Faker;

$factory->define(Clients::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name,
        'company_name' => $faker->name,
        'company_website' => $faker->url,
        'gender' => 'Male',
        'role' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'mobile' => '455555555',
        'address' => $faker->address,
        'state' => '37',
        'city' => '4509',
        'created_at' => date('Y-m-d H:i:s'),
    ];
});
