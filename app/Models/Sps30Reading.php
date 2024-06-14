<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sps30Reading extends Model
{
    protected $fillable = [
        'pm1_0',
        'pm2_5',
        'pm4',
        'pm10',
    
    ];
    
    protected $casts = [
        'pm1_0' => 'float',
        'pm2_5' => 'float',
        'pm4' => 'float',
        'pm10' => 'float',
    
    ];   
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/sps30-readings/'.$this->getKey());
    }
}
