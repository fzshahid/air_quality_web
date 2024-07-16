<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AirQualityReading extends Model
{
    protected $fillable = [
        'temperature',
        'humidity',
        'co2',
        'pm1_0',
        'pm2_5',
        'pm4',
        'pm10',
        'eco2',
        'tvoc',
        'aqi_pm2_5',
        'aqi_pm10',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/air-quality-readings/'.$this->getKey());
    }
}
