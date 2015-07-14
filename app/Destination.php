<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{

    public $timestamps = false;

    public function content()
    {
        return $this->belongsToMany('App\Content');
    }

}
