<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Baum;

class Destination extends Baum\Node
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

        return $this->flags->where('flag_type', 'havebeen');
    }

    public function usersWantsToGo()
    {

        return $this->flags->where('flag_type', 'wantstogo');
    }

}
