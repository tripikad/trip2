<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Booking extends Model
{
    protected $fillable = ['booking_id', 'user_id', 'data'];

    protected $casts = [
    'data' => 'object'
  ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function offer()
    {
        return $this->belongsTo('App\Offer');
    }
}
