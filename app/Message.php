<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = ['user_id_from', 'user_id_to', 'body'];

    protected $appends = ['title', 'body_filtered'];

    // Relations

    public function fromUser()
    {
        return $this->belongsTo('App\User', 'user_id_from');
    }

    public function toUser()
    {
        return $this->belongsTo('App\User', 'user_id_to');
    }

    public function withUser()
    {
        return $this->belongsTo('App\User', 'user_id_with');
    }

    public function vars()
    {
        return new MessageVars($this);
    }
}
