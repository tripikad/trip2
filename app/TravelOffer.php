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

    protected $fillable = ['name', 'slug'];

    protected $dates = ['start_date', 'end_date', 'created_at', 'updated_at'];

    protected $appends = [
        'status',
        'days',
        'nights'
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

    public function short_description()
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

    public function getDaysAttribute()
    {
        return $this->end_date->diffInDays($this->start_date);
    }

    public function getNightsAttribute()
    {
        return $this->days - 1;
    }
}