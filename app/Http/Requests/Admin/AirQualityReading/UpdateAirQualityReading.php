<?php

namespace App\Http\Requests\Admin\AirQualityReading;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateAirQualityReading extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.air-quality-reading.edit', $this->airQualityReading);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'temperature' => ['nullable', 'numeric'],
            'humidity' => ['nullable', 'numeric'],
            'co2' => ['nullable', 'numeric'],
            'pm1_0' => ['nullable', 'numeric'],
            'pm2_5' => ['nullable', 'numeric'],
            'pm4' => ['nullable', 'numeric'],
            'pm10' => ['nullable', 'numeric'],
            'eco2' => ['nullable', 'numeric'],
            'tvoc' => ['nullable', 'numeric'],
            
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
