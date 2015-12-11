<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['user_id_from', 'user_id_to', 'body'];

    protected $appends = ['title', 'body_filtered'];

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
        return str_limit($this->attributes['body'], 70);
    }

    public function getBodyAttribute($value)
    {
        return $value;
    }

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
}
