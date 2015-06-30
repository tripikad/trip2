<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    public function fromUser()
    {
        return $this->belongsTo('App\User', 'user_id_from');
    }

    public function toUser()
    {
        return $this->belongsTo('App\User', 'user_id_to');
    }

}
