<?php

namespace App;

use Baum;
use Cviebrock\EloquentSluggable\Sluggable as Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers as SlugHelper;

class Destination extends Baum\Node
{
    use Sluggable, SlugHelper;

    public $timestamps = false;

    public function content()
    {
        return $this->belongsToMany('App\Content');
    }

    public function content_flights()
    {
        return $this->content()->where('type', 'flight');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function flags()
    {
        return $this->morphMany('App\Flag', 'flaggable');
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function vars()
    {
        return new DestinationVars($this);
    }

    // Destinations API

    public function scopeContinents($query)
    {
        return $query->where('depth', 0);
    }

    public function scopeCountries($query)
    {
        return $query->where('depth', 1);
    }

    public function scopeCities($query)
    {
        return $query->where('depth', 2);
    }

    public function scopePlaces($query)
    {
        return $query->where('depth', 3);
    }

    public function isContinent()
    {
        return $this->depth == 0;
    }

    public function isCountry()
    {
        return $this->depth == 1;
    }

    public function isCity()
    {
        return $this->depth == 2;
    }

    public function isPlace()
    {
        return $this->depth > 2;
    }
}
