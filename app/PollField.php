<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollField extends Model
{
    protected $table = 'poll_fields';
    
    protected $fillable = ['type', 'options'];
    
    public $timestamps = false;
    
    public function poll()
    {
        return $this->belongsTo('App\Poll', 'poll_id', 'id');
    }
    
    public function poll_result()
    {
        return $this->hasMany('App\PollResult', 'field_id', 'field_id');
    }
}
