<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function destinations()
    {
        return $this->belongsToMany('App\Destination');
    }

    public function topics()
    {
        return $this->belongsToMany('App\Topic');
    }

    public function carriers()
    {
        return $this->belongsToMany('App\Carrier', 'content_carrier');
    }

    public function flags()
    {
     return $this->morphMany('App\Flag', 'flaggable');
    }

    public function followers()
    {
       return $this->morphMany('App\Follow', 'followable');
    }

    public function imagePath()
    {
        return $this->image ? '/images/' . $this->type . '/' . $this->image : 'http://trip.ee/files/pictures/picture_none.png';
    }

}
