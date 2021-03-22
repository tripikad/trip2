<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelOfferHotel extends Model
{
    protected $table = 'travel_offer_hotels';

    //public bool $timestamps = false;

    public function usesTimestamps()
    {
        return false;
    }

    public function travel_offer()
    {
        return $this->belongsTo('App\TravelOffer');
    }
}
