<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flag extends Model
{

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function flaggable()
    {
        return $this->morphTo();
    }

}
