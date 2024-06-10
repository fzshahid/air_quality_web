<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scd41Reading extends Model
{
    protected $fillable = [
        'temperature',
        'humidity',
        'eco2',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/scd41-readings/'.$this->getKey());
    }
}
