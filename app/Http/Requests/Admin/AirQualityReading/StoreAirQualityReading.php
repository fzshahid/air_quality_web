<?php

namespace App\Http\Requests\Admin\AirQualityReading;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreAirQualityReading extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.air-quality-reading.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'temperature' => 'numeric|between:-40,85',
            'humidity' => 'numeric|between:0,100',
            'co2' => 'numeric|between:400,5000',
            'pm1_0' => 'numeric|min:0',
            'pm2_5' => 'numeric|min:0',
            'pm4' => 'numeric|min:0',
            'pm10' => 'numeric|min:0',
            'eco2' => 'numeric|between:400,5000',
            'tvoc' => 'numeric|min:0',
        ];
    }


    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'temperature.between' => 'Temperature must be between -40 and 85 degrees Celsius.',
            'humidity.between' => 'Humidity must be between 0 and 100 percent.',
            'co2.between' => 'CO2 levels must be between 400 and 5000 ppm.',
            'eco2.between' => 'Equivalent CO2 levels must be between 400 and 5000 ppm.',
        ];
    }

    /**
    * Modify input data
    *
    * @return array
    */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
