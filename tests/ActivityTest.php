<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Content;
use App\Comment;

class ActivityTest extends TestCase
{
    use DatabaseTransactions;

    public function test_unlogged_user_can_see_user_activity()
    {
        $user1 = factory(App\User::class)->create(['verified' => true]);

        // Content activity

        $content1 = factory(Content::class)->create([
            'user_id' => $user1->id,
            'title' => 'Hello',
        ]);

        $this->visit("user/$user1->id")
            ->see($user1->name)
            ->see('Hello')
            ->click(trans('user.activity.view.full.post'), "content/$content1->type/$content1->id")
            ->seePageIs("content/$content1->type/$content1->id");

        // Comment activity

        $comment1 = factory(Comment::class)->create([
            'user_id' => $user1->id,
            'content_id' => $content1->id,
            'body' => 'World',
        ]);

        $this->visit("user/$user1->id")
            ->see('World')
            ->click(trans('user.activity.view.full.post'), "content/$comment1->content->type/$comment1->content->id?#comment-$comment1->id")
            ->seePageIs("content/$content1->type/$content1->id");
    }
}
