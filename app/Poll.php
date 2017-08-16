<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $table = 'poll';
    
    protected $fillable = ['name', 'start_date', 'end_date', 'type'];
    
    public $timestamps = false;
    
    public function content()
    {
        return $this->belongsTo('App\Content', 'id', 'id');
    }
    
    public function poll_fields()
    {
        return $this->hasMany('App\PollField', 'poll_id', 'id');
    }
    
    public function poll_results()
    {
        return $this->hasMany('App\PollResult', 'poll_id', 'id');
    }
}
