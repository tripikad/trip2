<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UnreadContent extends Model
{
    public $timestamps = false;
    protected $dates = [
        'read_at',
    ];

    public function content()
    {
        return $this->hasOne('App\Content', 'id', 'content_id');
    }

    public function getUnread(Content $content)
    {
        $unread_timestamp = $this->read_at->timestamp;
        $content_unread = false;

        // To avoid 99999 unread issue - quick fix - can be removed 2-3 weeks after live merge
        $unread_data = [
            'count' => 0,
            'first_comment_id' => null,
        ];

        if ($this->content) {
            $content_created_at_timestamp = $content->created_at->timestamp;

            if ($content_created_at_timestamp > $unread_timestamp) {
                $unread_data['count'] += 1;
                $content_unread = true;
            }

            if ($content->comments) {
                foreach ($content->comments as &$comment) {
                    if ($comment->created_at->timestamp > $unread_timestamp) {
                        if ($content_unread) {
                            --$unread_data['count'];
                            $content_unread = false;
                        }

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
        $content_unread = false;

        $unread_data = [
            'count' => 0,
            'first_comment_id' => null,
        ];

        if ($unread_content && auth()->check()) {
            return (int) $unread_content->getUnread($content);
        } elseif (auth()->check()) {
            $unread_data['count'] += 1;
            $content_unread = true;

            if ($content->comments) {
                foreach ($content->comments as &$comment) {
                    if ($content_unread) {
                        --$unread_data['count'];
                        $content_unread = false;
                    }

                    if (! $unread_data['first_comment_id']) {
                        $unread_data['first_comment_id'] = $comment->id;
                    }

                    ++$unread_data['count'];
                }
            }
        }

        return $unread_data;
    }
}
