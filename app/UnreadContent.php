<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UnreadContent extends Model
{
    public $timestamps = false;
    protected static $except_timestamp_to = '2017-07-14 14:00:00'; // todo

    public function content()
    {
        return $this->hasOne('App\Content', 'id', 'content_id');
    }

    public function getUnread(Content $content)
    {
        $unread_timestamp = strtotime($this->read_at);
        $except_timestamp = strtotime(UnreadContent::$except_timestamp_to);
        $unread_data = [
            'count' => 0,
            'first_comment_id' => null,
        ];

        if ($this->content) {
            $content_created_at_timestamp = strtotime($content->created_at);
            if ($content_created_at_timestamp > $unread_timestamp && $except_timestamp < $content_created_at_timestamp) {
                $unread_data['count'] += 1;
            }

            if ($content->comments) {
                foreach ($content->comments as &$comment) {
                    if (strtotime($comment->created_at) > $unread_timestamp && $except_timestamp < strtotime($comment->created_at)) {
                        if (! $unread_data['first_comment_id']) {
                            $unread_data['first_comment_id'] = $comment->id;
                        }

                        ++$unread_data['count'];
                    }
                }
            }
        }

        return (int) $unread_data;
    }

    public static function getUnreadContent(Content $content)
    {
        $unread_content = $content->unread_content;

        $unread_data = [
            'count' => 0,
            'first_comment_id' => null,
        ];

        if ($unread_content && auth()->check()) {
            return (int) $unread_content->getUnread($content);
        } elseif (auth()->check()) {
            $except_timestamp = strtotime(UnreadContent::$except_timestamp_to);
            $content_created_at_timestamp = strtotime($content->created_at);

            if ($except_timestamp < $content_created_at_timestamp) {
                $unread_data['count'] += 1;
            }

            if ($content->comments) {
                foreach ($content->comments as &$comment) {
                    if ($except_timestamp < strtotime($comment->created_at)) {
                        if (! $unread_data['first_comment_id']) {
                            $unread_data['first_comment_id'] = $comment->id;
                        }

                        ++$unread_data['count'];
                    }
                }
            }
        }

        return $unread_data;
    }
}
