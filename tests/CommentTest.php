<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Content;
use App\Comment;

class CommentTest extends TestCase
{
    use DatabaseTransactions;

    public function test_regular_user_can_create_comment()
    {

        $regular_user = factory(App\User::class)->create();

        $content = factory(Content::class)->create([
            'user_id' => factory(App\User::class)->create()->id,
            'title' => 'Hello'
        ]);

        // Add comment

        $this->actingAs($regular_user)
            ->visit("content/$content->type/$content->id")
            ->type('World', 'body')
            ->press(trans('comment.create.submit.title'))
            ->seePageIs("content/$content->type/$content->id")
            ->see('World')
            ->see($regular_user->name)
            ->seeInDatabase('comments', [
                'user_id' => $regular_user->id,
                'content_id' => $content->id,
                'body' => 'World',
                'status' => 1
            ]);

        $comment = Comment::whereBody('World')->first();

        // Edit own comment

        $this->actingAs($regular_user)
            ->visit("content/$content->type/$content->id")
            ->press(trans('comment.action.edit.title'))
            ->seePageIs("comment/$comment->id/edit")
            ->type('Earth', 'body')
            ->press(trans('comment.edit.submit.title'))
            ->seePageIs("content/$content->type/$content->id")
            ->see('Earth')
            ->seeInDatabase('comments', [
                'user_id' => $regular_user->id,
                'content_id' => $content->id,
                'body' => 'Earth',
                'status' => 1
            ]);

    }

}