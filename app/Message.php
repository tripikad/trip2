<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    protected $fillable = ['user_id_from', 'user_id_to', 'body'];

    protected $appends = ['title'];
    
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

   public function getTitleAttribute()
   {
       return str_limit($this->attributes['body'], 30);
   }

   public function getBodyAttribute($value)
   {
       return $value;
   }

}
