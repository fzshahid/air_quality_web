<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ccs811Reading extends Model
{
    protected $fillable = [
        'temperature',
        'humidity',
        'eco2',
        'tvoc',
    
    ];
    
    
    protected $casts = [
        'temperature' => 'float',
        'humidity' => 'float',
        'eco2' => 'float',
        'tvoc' => 'float',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/ccs811-readings/'.$this->getKey());
    }
}
