<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnreadContent extends Model
{
    protected $appends = [
        'unread',
    ];

    public function content()
    {
        return $this->hasOne('App\Content', 'id', 'content_id');
    }

    public function getUnreadAttribute()
    {
        $unread_timestamp = strtotime($this->read_at);
        $unread_count = 0;

        if ($this->content) {
            if ($this->content->comments) {
                foreach ($this->content->comments as $comment) {
                    if (strtotime($comment->created_at) > $unread_timestamp) {
                        ++$unread_count;
                    }
                }
            }
        }

        return (int) $unread_count;
    }
}
