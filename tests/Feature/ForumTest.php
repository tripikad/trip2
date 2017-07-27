<?php

namespace Tests\Feature;

use App\User;
use App\Content;
use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ForumTest extends BrowserKitTestCase
{
    use DatabaseTransactions;

    public function test_regular_user_can_create_forum_post()
    {
        $regular_user_creating_forum = factory(User::class)->create();

        $this->actingAs($regular_user_creating_forum)
            ->visit('foorum/uldfoorum')
            ->click(trans('content.forum.create.title'))
            ->seePageIs('forum/create')
            ->type('Hello forum title', 'title')
            ->type('Hello forum body', 'body')
            ->press(trans('content.create.submit.title'))
            ->seePageIs('foorum/uldfoorum')
            ->see('Hello forum title')
            ->seeInDatabase('contents', [
                'user_id' => $regular_user_creating_forum->id,
                'title' => 'Hello forum title',
                'body' => 'Hello forum body',
                'type' => 'forum',
                'status' => 1,
            ]);

        $content = Content::whereTitle('Hello forum title')->first();

        $this->actingAs($regular_user_creating_forum)
            ->visit("foorum/uldfoorum/$content->slug")
            ->click(trans('content.action.edit.title'))
            ->seePageIs("forum/$content->id/edit")
            ->type('Hola forum titulo', 'title')
            ->type('Hola forum cuerpo', 'body')
            ->press(trans('content.edit.submit.title'))
            ->seePageIs("foorum/uldfoorum/$content->slug")
            ->see('Hola forum titulo')
            ->see('Hola forum cuerpo')
            ->seeInDatabase('contents', [
                'user_id' => $regular_user_creating_forum->id,
                'title' => 'Hola forum titulo',
                'body' => 'Hola forum cuerpo',
                'type' => 'forum',
                'status' => 1,
            ]);
    }
}
