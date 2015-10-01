<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Content;

class CommentTest extends TestCase
{
    use DatabaseTransactions;

    public function test_regular_user_can_create_comment()
    {

        $user1 = factory(App\User::class)->create();
        $user2 = factory(App\User::class)->create();

        $content1 = factory(Content::class)->create([
            'user_id' => $user1->id,
            'title' => 'Hello'
        ]);

        // Add comment

        $this->actingAs($user2)
            ->visit("content/$content1->type/$content1->id")
            ->type('World', 'body')
            ->press(trans('comment.create.submit.title'))
            ->seePageIs("content/$content1->type/$content1->id")
            ->see('World')
            ->see($user2->name);

        $this->seeInDatabase('comments', [
            'user_id' => $user2->id,
            'content_id' => $content1->id,
            'body' => 'World',
            'status' => 1
        ]);

    }

}