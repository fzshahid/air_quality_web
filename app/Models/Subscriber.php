<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Subscriber extends Model
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
    ];

    protected $appends = ['subscribed_at', 'resource_url'];


    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/subscribers/'.$this->getKey());
    }

    public function getSubscribedAtAttribute() {
        return Carbon::parse($this->getAttribute('created_at'))->format('d/m/Y H:m');
    }
}
