<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Content;
use App\Comment;
use Carbon\Carbon;

class CommentTest extends TestCase
{
    use DatabaseTransactions;

    protected $publicContentTypes;

    public function setUp()
    {
        parent::setUp();

        $this->publicContentTypes = [
            'blog',
            'flight',
            'forum',
            'expat',
            'buysell',
            'news',
            'shortnews',
            'photo',
            'travelmate',
        ];

        $this->privateContentTypes = [
            'internal',
            'static',
        ];
    }

    public function test_regular_user_can_create_and_edit_comment()
    {
        $regular_user = factory(App\User::class)->create();

        foreach ($this->publicContentTypes as $type) {
            $content = factory(Content::class)->create([
                'user_id' => factory(App\User::class)->create()->id,
                'type' => $type,
                'end_at' => Carbon::now()->addDays(30),
                'start_at' => Carbon::now()->addDays(30),
            ]);

            // Can comment

            $this->actingAs($regular_user)
                ->visit("content/$content->type/$content->id")
                ->type("Hello $content->type", 'body')
                ->press(trans('comment.create.submit.title'))
                ->seePageIs("content/$content->type/$content->id")
                ->see("Hello $content->type")
                ->see($regular_user->name)
                ->seeInDatabase('comments', [
                    'user_id' => $regular_user->id,
                    'content_id' => $content->id,
                    'body' => "Hello $content->type",
                    'status' => 1,
                ]);

            $comment = Comment::whereBody("Hello $content->type")->first();

            // Can edit own comment

            $this->actingAs($regular_user)
                ->visit("content/$content->type/$content->id")
                ->press(trans('comment.action.edit.title'))
                ->seePageIs("comment/$comment->id/edit")
                ->type("Hola $content->type", 'body')
                ->press(trans('comment.edit.submit.title'))
                ->seePageIs("content/$content->type/$content->id")
                ->see("Hola $content->type")
                ->seeInDatabase('comments', [
                    'user_id' => $regular_user->id,
                    'content_id' => $content->id,
                    'body' => "Hola $content->type",
                    'status' => 1,
                ]);
        }
    }

    /**
     * !expectedException PHPUnit_Framework_ExpectationFailedException
     * !expectedExceptionMessage Received status code [401].
     */
    public function test_regular_user_cannot_edit_other_comments()
    {
        $regular_user = factory(App\User::class)->create();

        foreach ($this->publicContentTypes as $type) {
            $content = factory(Content::class)->create([
                'user_id' => factory(App\User::class)->create()->id,
                'type' => $type,
            ]);

            $comment = factory(Comment::class)->create([
                'user_id' => factory(App\User::class)->create()->id,
                'content_id' => $content->id,
            ]);

            // Can not edit other users comments

            $this->actingAs($regular_user)
                ->visit("content/$content->type/$content->id")
                ->dontSee(trans('comment.action.edit.title'))
                ->visit("comment/$comment->id/edit"); // 401
        }
    }

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Received status code [401]
     */
    public function test_regular_user_cannot_comments_on_private_content()
    {
        $regular_user = factory(App\User::class)->create();

        foreach ($this->privateContentTypes as $type) {
            $content = factory(Content::class)->create([
                'user_id' => factory(App\User::class)->create()->id,
                'type' => $type,
            ]);

            $comment = factory(Comment::class)->create([
                'user_id' => factory(App\User::class)->create()->id,
                'content_id' => $content->id,
            ]);

            // Can not add private content comments

            $this->actingAs($regular_user)
                ->visit("content/$content->type/$content->id")
                ->post("content/$content->type/$content->id/comment"); // 401

            // Can not edit private content comments

            $this->actingAs($regular_user)
                ->visit("content/$content->type/$content->id")
                ->dontSee(trans('comment.action.edit.title'))
                ->visit("comment/$comment->id/edit"); // 401
        }
    }
}
