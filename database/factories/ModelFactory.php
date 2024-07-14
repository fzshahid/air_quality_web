<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'last_login_at' => $faker->dateTime,
        
    ];
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\AirQualityReading::class, static function (Faker\Generator $faker) {
    return [
        'temperature' => $faker->randomFloat,
        'humidity' => $faker->randomFloat,
        'co2' => $faker->randomFloat,
        'pm1_0' => $faker->randomFloat,
        'pm2_5' => $faker->randomFloat,
        'pm4' => $faker->randomFloat,
        'pm10' => $faker->randomFloat,
        'eco2' => $faker->randomFloat,
        'tvoc' => $faker->randomFloat,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
