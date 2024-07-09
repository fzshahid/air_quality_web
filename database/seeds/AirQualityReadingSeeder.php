<?php

use Illuminate\Database\Seeder;
use App\Models\AirQualityReading;
use Carbon\Carbon;

class AirQualityReadingSeeder extends Seeder
{
    public function run()
    {
        $startDate = Carbon::now()->subMonth()->startOfMonth();
        $endDate = Carbon::now()->subMonth()->endOfMonth();

        while ($startDate->lessThanOrEqualTo($endDate)) {
            // dd(factory(AirQualityReading::class)->create());
            app()->make(AirQualityReading::class)->create([
                'humidity' => random_int(0, 100),
                'co2' => random_int(400, 5000),
                'pm1_0' => random_int(0, 500),
                'pm2_5' => random_int(0, 500),
                'pm4' => random_int(0, 500),
                'pm10' => random_int(0, 500),
                'eco2' => random_int(400, 5000),
                'tvoc' => random_int(0, 1000),
                'temperature' => random_int(-10, 50),
                'created_at' => $startDate->copy()->format(DATE_FORMAT),
                'updated_at' => $startDate->copy()->format(DATE_FORMAT),
            ]);

            $startDate->addMinutes(15);
        }
    }
}
