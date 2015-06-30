<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function followable()
    {
        return $this->morphTo();
    }

}
