<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{

    public $timestamps = false;

    public function content()
    {
        return $this->belongsToMany('App\Content');
    }

    public function flags()
    {

        return $this->morphMany('App\Flag', 'flaggable');

    }

    public function usersHaveBeen()
    {

        return $this->flags->where('flag_type', 'havebeen')->all();
    }

    public function usersWantsToGo()
    {

        return $this->flags->where('flag_type', 'wantstogo')->all();
    }

}
