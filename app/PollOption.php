<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{
    protected $fillable = ['poll_id', 'name'];
    protected $table = 'poll_options';

    public $timestamps = false;

    public function poll()
    {
        return $this->belongsTo('App\Poll', 'poll_id', 'id');
    }

    public function results()
    {
        return $this->hasMany('App\PollResult', 'poll_option_id', 'id');
    }

}
