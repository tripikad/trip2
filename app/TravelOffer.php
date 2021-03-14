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

    protected $dates = ['created_at', 'updated_at'];

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