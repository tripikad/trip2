<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Content;
use App\Comment;

class CommentTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Received status code [401]
     */

    public function test_regular_user_cannot_comments_on_private_content()
    {

        $regular_user = factory(App\User::class)->create();

        $types = [
            'internal',
            'static',
        ];

        foreach($types as $type) {

            $content = factory(Content::class)->create([
                'user_id' => factory(App\User::class)->create()->id,
                'title' => 'Hello',
                'type' => $type
            ]);

            $comment = factory(Comment::class)->create([
                'user_id' => factory(App\User::class)->create()->id,
                'content_id' => $content->id,
                'body' => 'World'
            ]);

            // Can not comment

            $this->actingAs($regular_user)
                ->visit("content/$content->type/$content->id")
                ->dontSee(trans('comment.create.submit.title'))
                ->post("content/$content->type/$content->id/comment"); // 401

            // Can not edit

            $this->actingAs($regular_user)
                ->visit("comment/$comment->id/edit"); // 401
        
        }
    
    }

    public function test_regular_user_can_create_and_edit_comment()
    {

        $regular_user = factory(App\User::class)->create();

        $types = [
            'blog',
            'flight',
            'forum',
            'expat',
            'buysell',
            'news',
            'shortnews',
            'photo',
            'travelmate'
        ];

        foreach($types as $type) {

            $content = factory(Content::class)->create([
                'user_id' => factory(App\User::class)->create()->id,
                'title' => 'Hello',
                'type' => $type
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

}