<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable as Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers as SlugHelper;

class Content extends Model
{
  use Sluggable, SlugHelper;

  const FLIGHT_IMAGE_DATE = '2019-08-15';

  // Setup

  protected $fillable = [
    'user_id',
    'type',
    'title',
    'body',
    'url',
    'image',
    'status',
    'start_at',
    'end_at',
    'duration',
    'price'
  ];

  protected $dates = ['created_at', 'updated_at', 'start_at', 'end_at'];

  protected $appends = ['body_filtered', 'image_id', 'views_count'];

  // Relations

  public function unread_content()
  {
    $user = auth()->user();

    $eager = $this->hasOne('App\UnreadContent', 'content_id', 'id');

    if ($user) {
      return $eager->where('user_id', $user->id);
    }

    return $eager;
  }

  public function views()
  {
    return $this->hasOne('App\Viewable', 'viewable_id', 'id');

    /*return $this->morphMany('App\Activity', 'activity')
      ->selectRaw('activity_id, count(*) as count')
      ->where('type', 'view')
      ->groupBy('activity_id');*/
  }

  public function getViewsCountAttribute()
  {
    if (!$this->views) {
      return 0;
    } else {
      return $this->views->count;
    }
  }

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

  // V1

  public function getDestinationParent()
  {
    if ($this->destinations->first()) {
      return $this->destinations
        ->first()
        ->parent()
        ->first();
    }
  }

  public function followersEmails()
  {
    $followerIds = $this->followers->pluck('user_id');

    return User::whereIn('id', $followerIds)
      ->where('notify_follow', 1)
      ->pluck('email', 'id');
  }

  public function imagePath()
  {
    $image = null;

    if ($this->image) {
      $image = config('imagepresets.presets.small.path') . $this->image;
    }

    if (!file_exists($image)) {
      $image = config('imagepresets.image.none');
    }

    return $image;
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
      return '[[' . $image->id . ']]';
    }
  }

  public function getActions()
  {
    $actions = [];

    if (auth()->user()) {
      $status = auth()
        ->user()
        ->follows()
        ->where([
          'followable_id' => $this->id,
          'followable_type' => 'App\Content'
        ])
        ->first()
        ? 0
        : 1;

      $actions['follow'] = [
        'title' => trans("content.action.follow.$status.title"),
        'route' => route('follow.follow.content', [$this->type, $this, $status]),
        'method' => 'PUT'
      ];
    }

    if (
      auth()->user() &&
      auth()
        ->user()
        ->hasRoleOrOwner('admin', $this->user->id)
    ) {
      $actions['edit'] = [
        'title' => trans('content.action.edit.title'),
        'route' => route('content.edit', ['type' => $this->type, 'id' => $this])
      ];
    }

    if (
      auth()->user() &&
      auth()
        ->user()
        ->hasRole('admin')
    ) {
      $actions['status'] = [
        'title' => trans("content.action.status.$this->status.title"),
        'route' => route('content.status', [$this->type, $this, 1 - $this->status]),
        'method' => 'PUT'
      ];
    }

    return $actions;
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
        'value' => count($goods),
        'flaggable' => Auth::check(),
        'flaggable_type' => 'content',
        'flaggable_id' => $this->id,
        'flag_type' => 'good',
        'active' => $good_active
      ],
      'bad' => [
        'value' => count($bads),
        'flaggable' => Auth::check(),
        'flaggable_type' => 'content',
        'flaggable_id' => $this->id,
        'flag_type' => 'bad',
        'active' => $bad_active
      ]
    ];
  }

  public function getHeadImage()
  {
    //fix for using copyrighted images
    if ($this->type === 'flight' && $this->created_at->format('Y-m-d') <= $this::FLIGHT_IMAGE_DATE) {
      return Image::getFlightHeader();
    }

    return $this->imagePreset('large');
  }

  public function sluggable()
  {
    return [
      'slug' => [
        'source' => 'title'
      ]
    ];
  }

  public function scopeGetLatestPagedItems(
    $query,
    $type,
    $take = 36,
    $destination = false,
    $topic = false,
    $order = 'created_at',
    array $additional_eager = []
  ) {
    $withs = ['images', 'user', 'user.images', 'comments', 'comments.user', 'destinations', 'topics', 'unread_content'];

    return $query
      ->whereType($type)
      ->whereStatus(1)
      ->orderBy($order, 'desc')
      ->with(array_merge($withs, $additional_eager))
      ->when($destination, function ($query) use ($destination) {
        $destinations = Destination::find($destination)
          ->descendantsAndSelf()
          ->pluck('id');

        return $query
          ->join('content_destination', 'content_destination.content_id', '=', 'contents.id')
          //->addSelect('contents.*')
          ->whereIn('content_destination.destination_id', $destinations);
      })
      ->when($topic, function ($query) use ($topic) {
        return $query
          ->join('content_topic', 'content_topic.content_id', '=', 'contents.id')
          //->addSelect('contents.*')
          ->where('content_topic.topic_id', '=', $topic);
      })
      ->select('contents.*')
      ->distinct()
      ->simplePaginate($take);
  }

  public function scopeGetLatestItems($query, $type, $take = 5, $order = 'created_at', array $additional_eager = [])
  {
    $eager = ['images', 'user', 'user.images', 'comments', 'comments.user', 'destinations', 'topics'];

    if (count($additional_eager)) {
      $eager = array_merge($eager, $additional_eager);
    }

    return $query
      ->whereType($type)
      ->whereStatus(1)
      ->take($take)
      ->orderBy($order, 'desc')
      ->with($eager)
      ->distinct()
      ->get();
  }

  public function scopeGetItemById($query, $id)
  {
    return $query
      ->whereStatus(1)
      ->with(
        'flags',
        'images',
        'user',
        'user.images',
        'comments',
        'comments.user.images',
        'comments.flags',
        'comments.content',
        'destinations',
        'topics'
      )
      ->findOrFail($id);
  }

  public function scopeGetItemBySlug($query, $slug, $user = false)
  {
    return $query
      ->whereSlug($slug)
      ->with(
        'flags',
        'images',
        'user',
        'user.images',
        'comments',
        'comments.user.images',
        'comments.flags',
        'comments.content',
        'destinations',
        'topics'
      )
      ->when(!$user || !$user->hasRole('admin'), function ($query) use ($user) {
        return $query->whereStatus(1);
      })
      ->first();
  }

  public function vars()
  {
    return new ContentVars($this);
  }
}
