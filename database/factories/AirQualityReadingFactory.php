<?php

// database/factories/AirQualityReadingFactory.php

use App\Models\AirQualityReading;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Carbon\Carbon;

$factory->define(AirQualityReading::class, function (Faker $faker) {
    static $timestamp = null;

    if (!$timestamp) {
        $timestamp = Carbon::now()->subMonth()->startOfMonth();
    } else {
        $timestamp->addMinutes(15);
    }


    return [
        'humidity' => $faker->numberBetween(0, 100),
        'co2' => $faker->numberBetween(400, 5000),
        'pm1_0' => $faker->numberBetween(0, 500),
        'pm2_5' => $faker->numberBetween(0, 500),
        'pm4' => $faker->numberBetween(0, 500),
        'pm10' => $faker->numberBetween(0, 500),
        'eco2' => $faker->numberBetween(400, 5000),
        'tvoc' => $faker->numberBetween(0, 1000),
        'temperature' => $faker->numberBetween(-10, 50),
        'created_at' => $timestamp->copy(), // Use a copy of the timestamp to avoid reference issues
        'updated_at' => $timestamp->copy(),
    ];
});
