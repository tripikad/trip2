<?php

namespace App;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable as Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers as SlugHelper;
use Illuminate\Database\Eloquent\Model;

class TravelOffer extends Model
{
    use Sluggable, SlugHelper;

    protected $table = 'travel_offers';

    protected $fillable = ['name'];

    protected $dates = ['start_date', 'end_date', 'created_at', 'updated_at'];

    protected $appends = [
        'status'
    ];

    protected $casts = [
        'active' => 'boolean',
        'data' => 'array'
    ];

    protected $with = [
        'company',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function short_description()
    {
        return mb_strimwidth(strip_tags($this->description), 0, 100, "...");
    }

    public function company()
    {
        return $this->hasOne('App\Company', 'id', 'company_id');
    }

    public function destinations()
    {
        return $this->belongsToMany('App\Destination', 'travel_offer_destinations');
    }

    public function destinationsBy($destinationId)
    {
        return $this->belongsToMany('App\Destination', 'travel_offer_destinations')
            ->where('training_id', $destinationId);
    }

    public function hotels()
    {
        return $this->hasMany('App\TravelOfferHotel');
    }

    public function images()
    {
        return $this->morphToMany('App\Image', 'imageable');
    }

    public function getStatusAttribute()
    {
        if ($this->end_date < Carbon::today()->toDateString()) {
            return 'expired';
        } else if ($this->active === true) {
            return 'active';
        } else {
            return 'draft';
        }
    }
}