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
        return $this->belongsToMany('App\Carrier');
    }

   public function flags()
   {
       return $this->morphMany('App\Flag', 'flaggable');
   }

}
