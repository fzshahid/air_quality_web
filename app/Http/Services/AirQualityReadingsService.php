<?php

namespace App\Http\Services;

use App\Models\AirQualityReading;
use App\Models\Ccs811Reading;
use App\Models\Scd41Reading;
use App\Models\Sps30Reading;
use Illuminate\Support\Arr;

class AirQualityReadingsService
{
    public function storeSps30(array $input) {
        $reading = Sps30Reading::create($input);
        return $reading;
    }
    public function storeScd41(array $input) {
        $reading = Scd41Reading::create($input);
        return $reading;
    }
    public function storeCcs811(array $input) {
        $reading = Ccs811Reading::create($input);
        return $reading;
    }

    
    public function store(array $input)
    {
        $pm25 = $input['pm2_5'];
        $pm10 = $input['pm10'];

        // Truncate the concentrations
        $pm25_truncated = $this->truncateValue($pm25, 0.1);
        $pm10_truncated = $this->truncateValue($pm10, 1);

        // Calculate AQI for PM2.5 and PM10
        $aqi_pm25 = $this->calculateAqi($pm25_truncated, $this->pm25Breakpoints());
        $aqi_pm10 = $this->calculateAqi($pm10_truncated, $this->pm10Breakpoints());

        $response = $this->checkVentilationNeed($input);
        // Store or process the input as needed

        // AirQualityReading::create($input);

        $pmMeasurements = [
            21, null, 35, 49.2, 48.6, 53.7, 66.2, 69.2, 64.9, 50, 43, 34.9
        ];
        $cast_now_aqi_pm25_truncated = $this->truncateValue($this->calculateNowCast($pmMeasurements), 0.1);
        $cast_now_aqi_pm25 = $this->calculateAqi($cast_now_aqi_pm25_truncated, $this->pm25Breakpoints());
        return [
            'aqi_pm_2_5' => $aqi_pm25,
            'aqi_pm_10' => $aqi_pm10,
            'cast_now_12_hour_aqi_pm25' => $cast_now_aqi_pm25,
            'ventilation' => $response,
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
                'message' => 'Air Quality is Good!'
            ],
            [
                "c_low" => 9.1,
                "c_high" => 35.4,
                "i_low" => 51,
                "i_high" => 100,
                'tag' => 'Moderate',
                'message' => 'Unusually sensitive people should consider reducing prolonged or heavy exertion.'
            ],
            [
                "c_low" => 35.5,
                "c_high" => 55.4,
                "i_low" => 101,
                "i_high" => 150,
                'tag' => 'Unhealthy for Sensitive Groups',
                'message' => 'People with heart or lung disease, older adults, children, and people of lower socioeconomic status should reduce prolonged or heavy exertion.'
            ],
            [
                "c_low" => 55.5,
                "c_high" => 125.4,
                "i_low" => 151,
                "i_high" => 200,
                'tag' => 'Unhealthy',
                'message' => 'People with heart or lung disease, older adults, children, and people of lower socioeconomic status should avoid prolonged or heavy exertion; everyone else should reduce prolonged or heavy exertion.'
            ],
            [
                "c_low" => 125.5,
                "c_high" => 225.4,
                "i_low" => 201,
                "i_high" => 300,
                'tag' => 'Very Unhealthy',
                'message' => 'People with heart or lung disease, older adults, children, and people of lower socioeconomic status should avoid all physical activity outdoors. Everyone else should avoid prolonged or heavy exertion.'
            ],
            [
                "c_low" => 225.5,
                "c_high" => 325.4,
                "i_low" => 301,
                "i_high" => 500,
                'tag' => 'Hazardous',
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
                'message' => 'Air Quality is Good!'
            ],
            [
                "c_low" => 55,
                "c_high" => 154,
                "i_low" => 51,
                "i_high" => 100,
                'tag' => 'Moderate',
                'message' => 'Unusually sensitive people should consider reducing prolonged or heavy exertion.'
            ],
            [
                "c_low" => 155,
                "c_high" => 254,
                "i_low" => 101,
                "i_high" => 150,
                'tag' => 'Unhealthy for Sensitive Groups',
                'message' => 'People with heart or lung disease, older adults, children, and people of lower socioeconomic status should reduce prolonged or heavy exertion.'
            ],
            [
                "c_low" => 255,
                "c_high" => 354,
                "i_low" => 151,
                "i_high" => 200,
                'tag' => 'Unhealthy',
                'message' => 'People with heart or lung disease, older adults, children, and people of lower socioeconomic status should avoid prolonged or heavy exertion; everyone else should reduce prolonged or heavy exertion.'
            ],
            [
                "c_low" => 355,
                "c_high" => 424,
                "i_low" => 201,
                "i_high" => 300,
                'tag' => 'Very Unhealthy',
                'message' => 'People with heart or lung disease, older adults, children, and people of lower socioeconomic status should avoid all physical activity outdoors. Everyone else should avoid prolonged or heavy exertion.'
            ],
            [
                "c_low" => 425,
                "c_high" => 604,
                "i_low" => 301,
                "i_high" => 500,
                'tag' => 'Hazardous',
                'message' => 'Everyone should avoid all physical activity outdoors; people with heart or lung disease, older adults, children, and people of lower socioeconomic status should remain indoors and keep activity levels low.'
            ],
            // Add additional breakpoints as needed
        ];
    }

    public function checkVentilationNeed(array $input)
    {
        $co2 = $input['co2'];
        $tvoc = $input['tvoc'];
        $humidity = $input['humidity'];
        $temperature = $input['temperature'];
        $pm25 = $input['pm2_5'];
        $pm10 = $input['pm10'];

        $ventilationNeeded = false;
        $messages = [];

        /**
         * 
         * https://www.umweltbundesamt.de/en/topics/health/commissions-working-groups/german-committee-on-indoor-air-guide-values#undefined
         * https://www.ncbi.nlm.nih.gov/pmc/articles/PMC8627286/
         * https://www.umweltbundesamt.de/sites/default/files/medien/4031/bilder/dateien/0_hygienic_guide_values_20220704_en.pdf (German Guide for Co2, PM2.5)
         * Although carbon dioxide levels below 800 ppm were considered an indicator of adequate ventilation based on CDC recommendations
         */
        if ($co2 > 800) {
            $ventilationNeeded = true;
            $messages[] = "High CO2 levels detected: {$co2} ppm. Ventilation needed.";
        }

        if ($tvoc > 1000) {
            $ventilationNeeded = true;
            $messages[] = "High tvoc levels detected: {$tvoc} ppb. Ventilation needed.";
        }

        /**
         * https://www.epa.gov/mold/brief-guide-mold-moisture-and-your-home
         */
        if ($humidity < 30 || $humidity > 50) {
            $ventilationNeeded = true;
            $messages[] = "Uncomfortable humidity levels: {$humidity}%. Ventilation needed.";
        }

        /**
         * https://document.airnow.gov/technical-assistance-document-for-the-reporting-of-daily-air-quailty.pdf
         */
        if ($pm25 > 35.4) {
            $ventilationNeeded = true;
            $messages[] = "High PM2.5 levels detected: {$pm25} µg/m³. Ventilation needed.";
        }

        /**
         * https://document.airnow.gov/technical-assistance-document-for-the-reporting-of-daily-air-quailty.pdf
         */
        if ($pm10 > 154) {
            $ventilationNeeded = true;
            $messages[] = "High PM10 levels detected: {$pm10} µg/m³. Ventilation needed.";
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
}
