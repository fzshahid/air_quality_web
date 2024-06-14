<?php

namespace App\Http\Requests\API\AirQualityReading;

use Illuminate\Foundation\Http\FormRequest;

class StoreSps30APIReading extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'pm1_0' => 'numeric|min:0',
            'pm2_5' => 'numeric|min:0',
            'pm4' => 'numeric|min:0',
            'pm10' => 'numeric|min:0',
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
