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

    // V2

    public function vars()
    {
        return new V2DestinationVars($this);
    }
}
