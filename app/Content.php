<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Cviebrock\EloquentSluggable\Sluggable as Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers as SlugHelper;

class Content extends Model
{
    use Sluggable, SlugHelper;

    // Setup

    protected $fillable = ['user_id', 'type', 'title', 'body', 'url', 'image', 'status', 'start_at', 'end_at', 'duration', 'price'];

    protected $dates = ['created_at', 'updated_at', 'start_at', 'end_at'];

    protected $appends = ['body_filtered', 'image_id'];

    // Relations

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

    // V2

    public function vars()
    {
        return new V2ContentVars($this);
    }

    public function scopeGetLatestPagedItems($query, $type, $take = 24)
    {
        return $query
            ->whereType($type)
            ->whereStatus(1)
            ->take($take)
            ->latest()
            ->get();
    }

    public function scopeGetLatestItems($query, $type, $take = 5)
    {
        return $query
            ->whereType($type)
            ->whereStatus(1)
            ->take($take)
            ->latest()
            ->get();
    }

    public function scopeGetItemById($query, $id) {

        return $query
            ->whereStatus(1)
            ->with(
                'images',
                'user',
                'user.images',
                'comments',
                'comments.user',
                'destinations',
                'topics'
            )
            ->findOrFail($id);
    
    }

    public function scopeGetItemBySlug($query, $slug) {

        return $query
            ->whereStatus(1)
            ->whereSlug($slug)
            ->with(
                'images',
                'user',
                'user.images',
                'comments',
                'comments.user',
                'destinations',
                'topics'
            )
            ->first();    
    }

    // V1

    public function getDestinationParent()
    {
        if ($this->destinations->first()) {
            return $this->destinations->first()->parent()->first();
        }
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
        $image = null;

        if ($this->image) {
            $image = config('imagepresets.presets.small.path').$this->image;
        }

        if (! file_exists($image)) {
            $image = config('imagepresets.image.none');
        }

        return $image;
    }

    public function getBodyFilteredAttribute()
    {
        return Main::getBodyFilteredAttribute($this);
    }

    public function images()
    {
        return $this->morphToMany('App\Image', 'imageable');
    }

    public function imagePreset($preset = 'small')
    {
        if ($this->images->count() > 0) {
            return $this->images->first()->preset($preset);
        }
    }

    public function getImageIdAttribute()
    {
        if ($image = $this->images()->first()) {
            return '[['.$image->id.']]';
        }
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

    public function getHeadTitle()
    {
        return isset($this->price) ? $this->title.' '.$this->price.'€' : $this->title;
    }

    public function getHeadDescription()
    {
        $description = str_replace(["\n", "\t", "\r"], '', strip_tags($this->body));
        $description = preg_replace("/\[\[([0-9]+)\]\]/", '', $description);

        return str_limit(trim($description), 200);
    }

    public function getHeadImage()
    {
        return config('app.url').$this->imagePreset('large');
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }
}
