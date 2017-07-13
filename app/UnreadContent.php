<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnreadContent extends Model
{
    protected $appends = [
        'unread',
    ];

    protected $except_timestamp_to = '2017-07-13 23:10:00'; // todo

    public function content()
    {
        return $this->hasOne('App\Content', 'id', 'content_id');
    }

    public function getUnreadAttribute()
    {
        $unread_timestamp = strtotime($this->read_at);
        $except_timestamp = strtotime($this->except_timestamp_to);
        $unread_count = 0;

        if ($this->content) {
            $content_created_at_timestamp = strtotime($this->content->created_at);
            if ($content_created_at_timestamp > $unread_timestamp && $except_timestamp < $content_created_at_timestamp) {
                $unread_count += 1;
            }

            if ($this->content->comments) {
                foreach ($this->content->comments as $comment) {
                    if (strtotime($comment->created_at) > $unread_timestamp && $except_timestamp < $unread_timestamp) {
                        ++$unread_count;
                    }
                }
            }
        }

        return (int) $unread_count;
    }
}
