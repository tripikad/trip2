<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable as Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers as SlugHelper;
use Illuminate\Database\Eloquent\Model;

class TravelOffer extends Model
{
    use Sluggable, SlugHelper;

    protected $table = 'travel_offers';

    protected $fillable = ['name', 'slug'];

    protected $dates = ['start_date', 'end_date', 'created_at', 'updated_at'];

    protected $appends = [
        //'status',
        'days',
        'nights',
        'actionRoutes'
    ];

    protected $casts = [
        'active' => 'boolean',
        'data' => 'array'
    ];

    protected $with = [
        'company',
        'endDestination'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['name']
            ]
        ];
    }

    public function shortDescription()
    {
        return mb_strimwidth(strip_tags($this->description), 0, 100, "...");
    }

    public function company()
    {
        return $this->hasOne('App\Company', 'id', 'company_id');
    }

    public function startDestination()
    {
        return $this->hasOne('App\Destination', 'id', 'start_destination_id');
    }

    public function endDestination()
    {
        return $this->hasOne('App\Destination', 'id', 'end_destination_id');
    }

    public function hotels()
    {
        return $this->hasMany('App\TravelOfferHotel')->orderBy('price');
    }

    public function images()
    {
        return $this->morphToMany('App\Image', 'imageable');
    }

    public function views()
    {
        return $this->hasOne('App\Viewable', 'viewable_id', 'id');
    }

    /*public function getStatusAttribute()
    {
        if ($this->end_date < Carbon::today()->toDateString()) {
            return 'expired';
        } else if ($this->active === true) {
            return 'active';
        } else {
            return 'draft';
        }
    }*/

    public function getNightsAttribute(): int
    {
        return $this->end_date->diffInDays($this->start_date);
    }

    public function getDaysAttribute(): int
    {
        return $this->nights + 1;
    }

    public function getActionRoutesAttribute(): array
    {
        return [
            'show' => route('travel_offer.travel_package.show', ['slug' => $this->slug]),
            'edit' => route('company.edit_travel_offer', ['company' => $this->company_id, 'travelOffer' => $this])
        ];
    }
}