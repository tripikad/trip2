<?php

namespace App;

use Exception;

class V2UserVars
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return call_user_func([$this, $property]);
        }

        $message = '%s does not respond to the "%s" property or method.';

        throw new Exception(
            sprintf($message, static::class, $property)
        );
    }

    public function name()
    {
        return str_limit($this->user->name, 30);
    }

    public function rank()
    {
        return $this->user->rank * 90;
    }

    public function likesCount()
    {
        return $this->user->likes()->count();
    }

    public function contentCount()
    {
        $types = ['forum', 'travelmate', 'photo', 'blog', 'news', 'flights'];

        return $this->user->contents()
            ->whereStatus(1)
            ->whereIn('type', $types)
            ->count();
    }

    public function commentCount()
    {
        $types = ['forum', 'travelmate', 'photo', 'blog', 'news', 'flights'];

        return $this->user->comments()
            ->whereStatus(1)
            ->whereHas('content', function ($query) use ($types) {
                $query->whereIn('type', $types);
            })
        ->count();
    }

    public function destinationHaveBeen()
    {
        return $this->user->flags->where('flag_type', 'havebeen');
    }

    public function destinationWantsToGo()
    {
        return $this->user->flags->where('flag_type', 'wantstogo');
    }

    public function destinationCount()
    {
        return $this->user->destinationHaveBeen()->count();
    }

    public function destinationCountPercentage()
    {
        $destinationsCount = Destination::count();

        if ($this->destinationCount() > 0 && $destinationsCount > 0) {
            return round(($this->user->destinationHaveBeen()->count() * 100) / $destinationsCount, 1);
        }

        return 0;
    }

    public function likes()
    {
        return $this->user->flags->where('flag_type', 'good');
    }

    public function hasFlaggedContent($content, $flagType)
    {
        return (bool) $this->user->flags
            ->where('flag_type', $flagType)
            ->where('flaggable_type', 'App\Content')
            ->where('flaggable_id', $content->id)
            ->count();
    }

    public function hasFlaggedComment($comment, $flagType)
    {
        return (bool) $this->user->flags
            ->where('flag_type', $flagType)
            ->where('flaggable_type', 'App\Comment')
            ->where('flaggable_id', $comment->id)
            ->count();
    }

    public function created_at_relative()
    {
        return $this->user->created_at->diffForHumans();
    }

    public function imagePreset($preset = 'small_square')
    {
        if ($image = $this->user->images->first()) {
            return $image->preset($preset);
        }

        return '/v2/svg/picture_none.svg';
    }
}
