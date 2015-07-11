<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = ['user_id', 'content_id', 'body'];

    protected $appends = ['title'];

    public function content()
    {
        return $this->belongsTo('App\Content');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

   public function flags()
   {
       return $this->morphMany('App\Flag', 'flaggable');
   }

   public function getTitleAttribute()
   {
       return str_limit($this->attributes['body'], 30);
   }

}
