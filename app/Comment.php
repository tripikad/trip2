<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Comment extends Model
{

  use Searchable;
    // Setup

    protected $fillable = ['user_id', 'content_id', 'body', 'status'];

    //protected $appends = ['title', 'body_filtered'];

    protected $touches = ['content'];

     public function SearchableAs()
    {
        return 'comments_index';
    }

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
        $goods = $this->flags->where('flag_type', 'good');
        $bads = $this->flags->where('flag_type', 'bad');

        $good_active = null;
        $bad_active = null;

        if (Auth::check()) {
            foreach ($goods as $good) {
                if ($good->user_id == Auth::user()->id) {
                    $good_active = 1;
                }
            }

            foreach ($bads as $bad) {
                if ($bad->user_id == Auth::user()->id) {
                    $bad_active = 1;
                }
            }
        }

        return [

          'good' => [
              'value' => count($this->flags->where('flag_type', 'good')),
              'flaggable' => Auth::check(),
              'flaggable_type' => 'comment',
              'flaggable_id' => $this->id,
              'flag_type' => 'good',
              'return' => '#comment-'.$this->id,
              'active' => $good_active,
          ],
          'bad' => [
              'value' => count($this->flags->where('flag_type', 'bad')),
              'flaggable' => Auth::check(),
              'flaggable_type' => 'comment',
              'flaggable_id' => $this->id,
              'flag_type' => 'bad',
              'return' => '#comment-'.$this->id,
              'active' => $bad_active,
          ],

       ];
    }
}
