<?php

namespace Tests\Feature;

use App\User;
use App\Comment;
use App\Content;
use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActivityTest extends BrowserKitTestCase
{
    use DatabaseTransactions;

    public function test_unlogged_user_can_see_user_activity()
    {
        $user1 = factory(User::class)->create(['verified' => true]);

        // Comment activity

        $content1 = factory(Content::class)->create([
            'user_id' => $user1->id,
            'title' => 'Bom dia',
            'type' => 'forum',
        ]);

        $comment1 = factory(Comment::class)->create([
            'user_id' => $user1->id,
            'content_id' => $content1->id,
            'body' => 'Preciosa',
        ]);

        $this->visit("user/$user1->id")
            ->see('Preciosa')
            ->click(trans('user.activity.comments.row.2'))
            ->seePageIs("foorum/uldfoorum/$content1->slug");
    }
}
