<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollResult extends Model
{
    protected $table = 'poll_results';
    
    public function poll()
    {
        return $this->belongsTo('App\Poll', 'poll_id', 'id');
    }
    
    public function poll_field()
    {
        return $this->belongsTo('App\PollField', 'field_id', 'field_id')
    }
}
