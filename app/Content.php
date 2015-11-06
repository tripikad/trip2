<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Content extends Model
{
    protected $fillable = ['user_id', 'type', 'title', 'body', 'url', 'image', 'status', 'start_at', 'end_at', 'duration', 'price'];

    protected $dates = ['created_at', 'updated_at', 'start_at', 'end_at'];

    protected $appends = ['body_filtered','image_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function destinations()
    {
        return $this->belongsToMany('App\Destination');
    }

    public function topics()
    {
        return $this->belongsToMany('App\Topic');
    }

    public function carriers()
    {
        return $this->belongsToMany('App\Carrier', 'content_carrier');
    }

    public function flags()
    {
        return $this->morphMany('App\Flag', 'flaggable');
    }

    public function followers()
    {
        return $this->morphMany('App\Follow', 'followable');
    }

    public function destinationsPreset()
    {
        $destinationIds = [];

        if ($this->destinations) {
            $find = ['id', 'parent_id'];

            foreach ($find as $values) {
                if (isset($this->destinations->first()->$values)) {
                    $destinationIds[] = $this->destinations->first()->$values;
                }
            }
        }

        if (! empty($destinationIds)) {
            return Destination::whereIn('id', $destinationIds)
                ->get();
        }

        return;
    }

    public function destinationMainPreset($name = 'id')
    {
        if ($this->destinationsPreset()) {
            return $this->destinationsPreset()->first()->$name;
        }

        return;
    }

    public function destinationSubPreset($name = 'id')
    {
        if ($this->destinationsPreset()) {
            if ($this->destinationsPreset()->first()->id !== $this->destinationsPreset()->last()->id) {
                return $this->destinationsPreset()->last()->$name;
            }
        }

        return;
    }

    public function followersEmails()
    {
        $followerIds = $this->followers->lists('user_id');

        return User::whereIn('id', $followerIds)
            ->where('notify_follow', 1)
            ->lists('email', 'id');
    }

    public function imagePath()
    {
        return $this->image ? '/images/'.$this->type.'/small/'.$this->image : 'http://trip.ee/files/pictures/picture_none.png';
    }

//    public function getFilteredbodyAttribute()

    public function getBodyFilteredAttribute()
    {
        $pattern = '/\[\[([0-9]+)\]\]/';
        $filteredBody = $this->body;

        if (preg_match_all($pattern, $filteredBody, $matches)) {
            foreach ($matches[1] as $match) {
                if ($image = \App\Image::find($match)) {
                    $filteredBody = str_replace("[[$image->id]]", '<img src="'.$image->preset('medium').'" />', $filteredBody);
                }
            }
        }

        return nl2br($filteredBody);
    }

    public function images()
    {
        return $this->morphToMany('App\Image', 'imageable');
    }

    public function imagePreset($preset = 'small')
    {
        if ($image = $this->images()->first()) {
            return $image->preset($preset);
        }

        return;
    }

    public function getImageIdAttribute()
    {
        if ($image = $this->images()->first()) {
            return '[['.$image->id.']]';
        }

        return;
    }

    public function getActions()
    {
        $actions = [];

        if (auth()->user()) {
            $status = auth()->user()->follows()->where([
                'followable_id' => $this->id,
                'followable_type' => 'App\Content',
            ])->first() ? 0 : 1;

            $actions['follow'] = [
                'title' => trans("content.action.follow.$status.title"),
                'route' => route('follow.follow.content', [$this->type, $this, $status]),
                'method' => 'PUT',
            ];
        }

        if (auth()->user() && auth()->user()->hasRoleOrOwner('admin', $this->user->id)) {
            $actions['edit'] = [
                'title' => trans('content.action.edit.title'),
                'route' => route('content.edit', ['type' => $this->type, 'id' => $this]),
            ];
        }

        if (auth()->user() && auth()->user()->hasRole('admin')) {
            $actions['status'] = [
                'title' => trans("content.action.status.$this->status.title"),
                'route' => route('content.status', [$this->type, $this, (1 - $this->status)]),
                'method' => 'PUT',
            ];
        }

        return $actions;
    }

    public function getFlags()
    {
        return [

            'good' => [
                'value' => count($this->flags->where('flag_type', 'good')),
                'flaggable' => Auth::check(),
                'flaggable_type' => 'content',
                'flaggable_id' => $this->id,
                'flag_type' => 'good',
            ],
            'bad' => [
                'value' => count($this->flags->where('flag_type', 'bad')),
                'flaggable' => Auth::check(),
                'flaggable_type' => 'content',
                'flaggable_id' => $this->id,
                'flag_type' => 'bad',
            ],
        ];
    }
}
