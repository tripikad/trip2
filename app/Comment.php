<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = ['user_id', 'content_id', 'body', 'status'];

    protected $appends = ['title'];

    protected $touches = ['content'];

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

   public function getActionsAttribute()
   {

       $actions = [];

       if (auth()->user() && auth()->user()->hasRoleOrOwner('admin', $this->user->id)) {
           
           $actions['edit'] = [
               'title' => trans('comment.action.edit.title'),
               'route' => route('comment.edit', [$this])
           ];
           
       }

       if (auth()->user() && auth()->user()->hasRole('admin')) {
           
           $actions['status'] = [
               'title' => trans("comment.action.status.$this->status.title"),
               'route' => route('comment.status', [$this, (1 - $this->status)])
           ];
           
       }
       
       return $actions;
   
   }

}
