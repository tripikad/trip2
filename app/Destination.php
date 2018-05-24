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
                'source' => 'name',
            ],
        ];
    }

    public function vars()
    {
        return new DestinationVars($this);
    }
}
