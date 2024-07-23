<?php

namespace App\Http\Services;

use App\Models\AirQualityReading;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Enums\DataCategoriesEnum;

class AirQualityReadingsService
{
    /**
     * Store AirQualityReading
     *
     * @param array $sanitized
     * @return \App\Models\AirQualityReading
     */
    public function store(array $sanitized)
    {
        // Store the AirQualityReading
        // $sanitized['pm1_0'] = round($sanitized['pm1_0'] / 1000, 2);
        // $sanitized['pm2_5'] = round($sanitized['pm2_5'] / 1000, 2);
        // $sanitized['pm4'] = round($sanitized['pm4'] / 1000, 2);
        // $sanitized['pm10'] = round($sanitized['pm10'] / 1000, 2);

        $airQualityReading = \App\Models\AirQualityReading::create($sanitized);

        $aqiData = $this->calculateAqiIndex($airQualityReading);

        $airQualityReading->aqi_pm2_5 = $aqiData['aqi_pm2_5']['aqi'];
        $airQualityReading->aqi_pm10 = $aqiData['aqi_pm10']['aqi'];
        $airQualityReading->save();

        return $airQualityReading;
    }

    public function calculateAqiIndex(\App\Models\AirQualityReading $airQualityReading)
    {
        // Truncate the concentrations
        $pm25_truncated = $this->truncateValue($airQualityReading->pm2_5, 0.1);
        $pm10_truncated = $this->truncateValue($airQualityReading->pm10, 1);

        // Calculate AQI for PM2.5 and PM10
        $aqi_pm25 = $this->calculateAqi($pm25_truncated, $this->pm25Breakpoints());
        $aqi_pm10 = $this->calculateAqi($pm10_truncated, $this->pm10Breakpoints());

        // $response = $this->checkVentilationNeed($input);
        // Store or process the input as needed

        // AirQualityReading::create($input);

        // $pmMeasurements = [
        //     21, null, 35, 49.2, 48.6, 53.7, 66.2, 69.2, 64.9, 50, 43, 34.9
        // ];
        // $cast_now_aqi_pm25_truncated = $this->truncateValue($this->calculateNowCast($pmMeasurements), 0.1);
        // $cast_now_aqi_pm25 = $this->calculateAqi($cast_now_aqi_pm25_truncated, $this->pm25Breakpoints());
        return [
            'aqi_pm2_5' => $aqi_pm25,
            'aqi_pm10' => $aqi_pm10,
            // 'cast_now_12_hour_aqi_pm25' => $cast_now_aqi_pm25,
            // 'ventilation' => $response,
        ];
    }

    private function calculateAqi($concentration, $breakpoints)
    {
        /**
         * https://forum.airnowtech.org/t/daily-and-hourly-aqi-pm2-5/171
         * 
         */
        foreach ($breakpoints as $bp) {
            if ($bp['c_low'] <= $concentration && $concentration <= $bp['c_high']) {
                $aqi = (($bp['i_high'] - $bp['i_low']) / ($bp['c_high'] - $bp['c_low'])) * ($concentration - $bp['c_low']) + $bp['i_low'];
                return [
                    'aqi' => round($aqi),
                    'tag' => $bp['tag'],
                    'class' => $bp['class'],
                    'intensity' => $bp['intensity'],
                    'message' => $bp['message'],
                ];
            }
        }
        return null;
    }

    private function truncateValue($value, $precision)
    {
        return floor($value / $precision) * $precision;
    }

    private function pm25Breakpoints()
    {
        /**
         * https://document.airnow.gov/technical-assistance-document-for-the-reporting-of-daily-air-quailty.pdf
         */
        return [
            [
                "c_low" => 0.0,
                "c_high" => 9.0,
                "i_low" => 0,
                "i_high" => 50,
                'tag' => 'Good',
                'class' => 'aqi-good',
                'intensity' => 0,
                'message' => 'Air Quality is Good!'
            ],
            [
                "c_low" => 9.1,
                "c_high" => 35.4,
                "i_low" => 51,
                "i_high" => 100,
                'tag' => 'Moderate',
                'class' => 'aqi-moderate',
                'intensity' => 1,
                'message' => 'Unusually sensitive people should consider reducing prolonged or heavy exertion.'
            ],
            [
                "c_low" => 35.5,
                "c_high" => 55.4,
                "i_low" => 101,
                "i_high" => 150,
                'tag' => 'Unhealthy for Sensitive Groups',
                'class' => 'aqi-unhealthy-for-sensitive-groups',
                'intensity' => 2,
                'message' => 'People with heart or lung disease, older adults, children, and people of lower socioeconomic status should reduce prolonged or heavy exertion.'
            ],
            [
                "c_low" => 55.5,
                "c_high" => 125.4,
                "i_low" => 151,
                "i_high" => 200,
                'tag' => 'Unhealthy',
                'class' => 'aqi-unhealthy',
                'intensity' => 3,
                'message' => 'People with heart or lung disease, older adults, children, and people of lower socioeconomic status should avoid prolonged or heavy exertion; everyone else should reduce prolonged or heavy exertion.'
            ],
            [
                "c_low" => 125.5,
                "c_high" => 225.4,
                "i_low" => 201,
                "i_high" => 300,
                'tag' => 'Very Unhealthy',
                'class' => 'aqi-very-unhealthy',
                'intensity' => 4,
                'message' => 'People with heart or lung disease, older adults, children, and people of lower socioeconomic status should avoid all physical activity outdoors. Everyone else should avoid prolonged or heavy exertion.'
            ],
            [
                "c_low" => 225.5,
                "c_high" => 325.4,
                "i_low" => 301,
                "i_high" => 500,
                'tag' => 'Hazardous',
                'class' => 'aqi-hazardous',
                'intensity' => 5,
                'message' => 'Everyone should avoid all physical activity outdoors; people with heart or lung disease, older adults, children, and people of lower socioeconomic status should remain indoors and keep activity levels low.'
            ],
            // Add additional breakpoints as needed
        ];
    }

    private function pm10Breakpoints()
    {
        /**
         * https://document.airnow.gov/technical-assistance-document-for-the-reporting-of-daily-air-quailty.pdf
         */
        return [
            [
                "c_low" => 0,
                "c_high" => 54,
                "i_low" => 0,
                "i_high" => 50,
                'tag' => 'Good',
                'class' => 'aqi-good',
                'intensity' => 0,
                'message' => 'Air Quality is Good!'
            ],
            [
                "c_low" => 55,
                "c_high" => 154,
                "i_low" => 51,
                "i_high" => 100,
                'tag' => 'Moderate',
                'class' => 'aqi-moderate',
                'intensity' => 1,
                'message' => 'Unusually sensitive people should consider reducing prolonged or heavy exertion.'
            ],
            [
                "c_low" => 155,
                "c_high" => 254,
                "i_low" => 101,
                "i_high" => 150,
                'tag' => 'Unhealthy for Sensitive Groups',
                'class' => 'aqi-unhealthy-for-sensitive-groups',
                'intensity' => 2,
                'message' => 'People with heart or lung disease, older adults, children, and people of lower socioeconomic status should reduce prolonged or heavy exertion.'
            ],
            [
                "c_low" => 255,
                "c_high" => 354,
                "i_low" => 151,
                "i_high" => 200,
                'tag' => 'Unhealthy',
                'class' => 'aqi-unhealthy',
                'intensity' => 3,
                'message' => 'People with heart or lung disease, older adults, children, and people of lower socioeconomic status should avoid prolonged or heavy exertion; everyone else should reduce prolonged or heavy exertion.'
            ],
            [
                "c_low" => 355,
                "c_high" => 424,
                "i_low" => 201,
                "i_high" => 300,
                'tag' => 'Very Unhealthy',
                'class' => 'aqi-very-unhealthy',
                'intensity' => 4,
                'message' => 'People with heart or lung disease, older adults, children, and people of lower socioeconomic status should avoid all physical activity outdoors. Everyone else should avoid prolonged or heavy exertion.'
            ],
            [
                "c_low" => 425,
                "c_high" => 604,
                "i_low" => 301,
                "i_high" => 500,
                'tag' => 'Hazardous',
                'class' => 'aqi-hazardous',
                'intensity' => 5,
                'message' => 'Everyone should avoid all physical activity outdoors; people with heart or lung disease, older adults, children, and people of lower socioeconomic status should remain indoors and keep activity levels low.'
            ],
            // Add additional breakpoints as needed
        ];
    }

    public function checkVentilationNeed(\App\Models\AirQualityReading $airQualityReading)
    {
        $co2 = $airQualityReading->co2;
        $tvoc = $airQualityReading->tvoc;
        $humidity = $airQualityReading->humidity;
        $temperature = $airQualityReading->temperature;
        $pm25 = $airQualityReading->pm2_5;
        $pm10 = $airQualityReading->pm10;

        $ventilationNeeded = false;
        $messages = [];

        $thresholds = config('constants.aqi_thresholds');
        /**
         * 
         * https://www.umweltbundesamt.de/en/topics/health/commissions-working-groups/german-committee-on-indoor-air-guide-values#undefined
         * https://www.ncbi.nlm.nih.gov/pmc/articles/PMC8627286/
         * https://www.umweltbundesamt.de/sites/default/files/medien/4031/bilder/dateien/0_hygienic_guide_values_20220704_en.pdf (German Guide for Co2, PM2.5)
         * Although carbon dioxide levels below 800 ppm were considered an indicator of adequate ventilation based on CDC recommendations
         */
        if ($co2 > $thresholds['co2']) {
            $ventilationNeeded = true;
            $messages[DataCategoriesEnum::CO2] = "High CO2 levels detected: {$co2} ppm.";
        }

        // if ($tvoc > $thresholds['tvoc']) {
        //     $ventilationNeeded = true;
        //     $messages[DataCategoriesEnum::TVOC] = "High tvoc levels detected: {$tvoc} ppb.";
        // }

        /**
         * https://www.epa.gov/mold/brief-guide-mold-moisture-and-your-home
         */
        // if ($humidity < $thresholds['min_humidity'] || $humidity > $thresholds['max_humidity']) {
        if ($humidity > $thresholds['max_humidity']) {
            $ventilationNeeded = true;
            $messages[DataCategoriesEnum::HUMIDITY] = "Uncomfortable humidity levels: {$humidity}%.";
        }

        /**
         * https://document.airnow.gov/technical-assistance-document-for-the-reporting-of-daily-air-quailty.pdf
         */
        if ($pm25 > $thresholds['pm2_5']) {
            $ventilationNeeded = true;
            $messages[DataCategoriesEnum::PM2_5] = "High PM2.5 levels detected: {$pm25} µg/m³.";
        }

        /**
         * https://document.airnow.gov/technical-assistance-document-for-the-reporting-of-daily-air-quailty.pdf
         */
        if ($pm10 > $thresholds['pm10']) {
            $ventilationNeeded = true;
            $messages[DataCategoriesEnum::PM10] = "High PM10 levels detected: {$pm10} µg/m³.";
        }

        return [
            'ventilation_needed' => $ventilationNeeded,
            'messages' => $messages,
        ];
    }

    /**
     * https://usepa.servicenowservices.com/airnow/en/how-is-the-nowcast-algorithm-used-to-report-current-air-quality?id=kb_article_view&sys_id=bb8b65ef1b06bc10028420eae54bcb98&spa=1
     * 
     * 
     */
    public function calculateNowCast(array $pmMeasurements)
    {
        // Check if there are enough measurements for calculation
        if (count($pmMeasurements) < 12) {
            return null; // Insufficient data
        }

        // Get the past 12 hours of PM measurements
        $last12Hours = array_slice($pmMeasurements, -12);

        // Select the minimum and maximum PM measurements
        $minPM = collect($last12Hours)->filter(function ($value) {
            return !is_null($value);
        })
            ->min();

        $maxPM = collect($last12Hours)->filter(function ($value) {
            return !is_null($value);
        })
            ->max();

        // Calculate the range
        $range = $maxPM - $minPM;

        // Calculate the scaled rate of change
        $scaledRateOfChange = $range / $maxPM;

        // Calculate the weight factor
        $weightFactor = 1 - $scaledRateOfChange;
        $weightFactor = max(0.5, $weightFactor);

        // Compute the NowCast
        $nowCast = 0;
        $sumProducts = 0;
        $sumWeightFactors = 0;

        foreach ($last12Hours as $index => $pm) {
            if (null != $pm) {
                $weight = pow($weightFactor, $index);
                $sumProducts += ($pm * $weight);
                $sumWeightFactors += $weight;
            }
        }

        if ($sumWeightFactors > 0) {
            $nowCast = $sumProducts / $sumWeightFactors;
        }

        return $nowCast;
    }


    public function getHourlyRate($hours)
    {
        $now = now();
        $startTime = $now->copy()->subHours($hours);

        $co2Rates = AirQualityReading::select(
            DB::raw('AVG(temperature) AS avg_temperature'),
            DB::raw('AVG(humidity) AS avg_humidity'),
            DB::raw('AVG(co2) AS avg_co2'),
            DB::raw('AVG(pm1_0) AS avg_pm1'),
            DB::raw('AVG(pm2_5) AS avg_pm2_5'),
            DB::raw('AVG(pm4) AS avg_pm4'),
            DB::raw('AVG(pm10) AS avg_pm10'),
            DB::raw('AVG(eco2) AS avg_eco2'),
            DB::raw('AVG(tvoc) AS avg_tvoc'),
            DB::raw('AVG(co2) as avg_co2'),
            DB::raw('HOUR(created_at) as hour')
        )
            ->whereBetween('created_at', [$startTime, $now])
            ->groupBy(DB::raw('HOUR(created_at)'))
            ->get();

        return ($co2Rates);
    }

    public function getDailyRate($days)
    {
        $now = Carbon::now();
        $startTime = $now->copy()->subDays($days);

        $co2Rates = AirQualityReading::select(
            DB::raw('AVG(temperature) AS avg_temperature'),
            DB::raw('AVG(humidity) AS avg_humidity'),
            DB::raw('AVG(co2) AS avg_co2'),
            DB::raw('AVG(pm1_0) AS avg_pm1'),
            DB::raw('AVG(pm2_5) AS avg_pm2_5'),
            DB::raw('AVG(pm4) AS avg_pm4'),
            DB::raw('AVG(pm10) AS avg_pm10'),
            DB::raw('AVG(eco2) AS avg_eco2'),
            DB::raw('AVG(tvoc) AS avg_tvoc'),
            DB::raw('AVG(co2) as avg_co2'),
            DB::raw('DATE(created_at) as date')
        )
            ->whereBetween('created_at', [$startTime, $now])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        return ($co2Rates);
    }

    /**
     * Get Chart Data
     *
     * @param string $lastFilter
     * @return \Illuminate\Support\Collection
     */
    public function getChartData($lastFilter)
    {
        $data = [];
        switch ($lastFilter) {
            case 'lastmonth':
                $data = $this->getDailyRate(30);

                break;
            case 'lastweek':
                $data = $this->getDailyRate(7);

                break;
            default:
                $data = $this->getHourlyRate(24);
                break;
        }

        $resp = [];
        foreach ($data as $key => $value) {
            // $dateFormatted = optional($value)->hour ?? optional($value)->date;
            $dateFormatted = optional($value)->hour !== null ? numberToTime($value->hour) : Carbon::parse($value->date)->format('d/m/Y');
            $temperature = [
                'category_name' => DataCategoriesEnum::TEMPERATURE,
                'date' => $dateFormatted,
                'total' => round($value->avg_temperature, 2),
            ];
            $co2 = [
                'category_name' => DataCategoriesEnum::CO2,
                'date' => $dateFormatted,
                'total' => round($value->avg_co2),
            ];
            $eco2 = [
                'category_name' => DataCategoriesEnum::ECO2,
                'date' => $dateFormatted,
                'total' => round($value->avg_eco2),
            ];
            $humidity = [
                'category_name' => DataCategoriesEnum::HUMIDITY,
                'date' => $dateFormatted,
                'total' => round($value->avg_humidity, 2),
            ];
            $tvoc = [
                'category_name' => DataCategoriesEnum::TVOC,
                'date' => $dateFormatted,
                'total' => round($value->avg_tvoc),
            ];
            $pm1 = [
                'category_name' => DataCategoriesEnum::PM1,
                'date' => $dateFormatted,
                'total' => round($value->avg_pm1),
            ];
            $pm2_5 = [
                'category_name' => DataCategoriesEnum::PM2_5,
                'date' => $dateFormatted,
                'total' => round($value->avg_pm2_5),
            ];
            $pm4 = [
                'category_name' => DataCategoriesEnum::PM4,
                'date' => $dateFormatted,
                'total' => round($value->avg_pm4),
            ];
            $pm10 = [
                'category_name' => DataCategoriesEnum::PM10,
                'date' => $dateFormatted,
                'total' => round($value->avg_pm10),
            ];
            array_push($resp, $temperature, $co2, $eco2, $humidity, $tvoc, $pm1, $pm2_5, $pm4, $pm10);
        }
        return collect($resp);
    }
}
