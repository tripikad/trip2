<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Comment extends Model
{
    // Setup

    protected $fillable = ['user_id', 'content_id', 'body', 'status'];

    protected $appends = ['title', 'body_filtered'];

    protected $touches = ['content'];

    // Relations

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

    // V2

    public function vars()
    {
        return new V2CommentVars($this);
    }

    // V1

    public function getTitleAttribute()
    {
        return str_limit($this->attributes['body'], 30);
    }

    public function getActions()
    {
        $actions = [];

        if (auth()->user() && auth()->user()->hasRoleOrOwner('admin', $this->user->id)) {
            $actions['edit'] = [
               'title' => trans('comment.action.edit.title'),
               'route' => route('comment.edit', [$this]),
           ];
        }

        if (auth()->user() && auth()->user()->hasRole('admin')) {
            $actions['status'] = [
               'title' => trans("comment.action.status.$this->status.title"),
               'route' => route('comment.status', [$this, (1 - $this->status)]),
               'method' => 'PUT',
           ];
        }

        return $actions;
    }

    public function getBodyFilteredAttribute()
    {
        return Main::getBodyFilteredAttribute($this);
    }

    public function getFlags()
    {
        return [

          'good' => [
              'value' => count($this->flags->where('flag_type', 'good')),
              'flaggable' => Auth::check(),
              'flaggable_type' => 'comment',
              'flaggable_id' => $this->id,
              'flag_type' => 'good',
              'return' => '#comment-'.$this->id,
          ],
          'bad' => [
              'value' => count($this->flags->where('flag_type', 'bad')),
              'flaggable' => Auth::check(),
              'flaggable_type' => 'comment',
              'flaggable_id' => $this->id,
              'flag_type' => 'bad',
              'return' => '#comment-'.$this->id,
          ],

       ];
    }
}
