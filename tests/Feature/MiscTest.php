<?php

namespace Tests\Feature;

use Auth;
use App\User;
use App\Content;
use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MiscTest extends BrowserKitTestCase
{
    use DatabaseTransactions;

    public function test_regular_user_can_create_misc_post()
    {
        $regular_user_creating_misc = factory(User::class)->create();

        $this->actingAs($regular_user_creating_misc)
            ->visit('foorum/vaba-teema')
            ->click(trans('content.misc.create.title'))
            ->seePageIs('forum/create/misc')
            ->type('Hello misc title', 'title')
            ->type('Hello misc body', 'body')
            ->press(trans('content.create.submit.title'))
            ->seePageIs('foorum/vaba-teema')
            ->see('Hello misc title')
            ->seeInDatabase('contents', [
                'user_id' => $regular_user_creating_misc->id,
                'title' => 'Hello misc title',
                'body' => 'Hello misc body',
                'type' => 'misc',
                'status' => 1,
            ]);

        $content = Content::whereTitle('Hello misc title')->first();

        $this->actingAs($regular_user_creating_misc)
            ->visit("foorum/vaba-teema/$content->slug")
            ->click(trans('content.action.edit.title'))
            ->seePageIs("forum/$content->id/edit")
            ->type('Hola misc titulo', 'title')
            ->type('Hola misc cuerpo', 'body')
            ->press(trans('content.edit.submit.title'))
            ->seePageIs("foorum/uldfoorum/$content->slug") // FIXME
            ->see('Hola misc titulo')
            ->see('Hola misc cuerpo')
            ->seeInDatabase('contents', [
                'user_id' => $regular_user_creating_misc->id,
                'title' => 'Hola misc titulo',
                'body' => 'Hola misc cuerpo',
                'type' => 'misc',
                'status' => 1,
            ]);
    }

    public function test_regular_user_can_see_but_can_not_edit_other_misc_posts()
    {
        $regular_user_creating_misc = factory(User::class)->create();
        $regular_user_viewing_misc = factory(User::class)->create();

        $this->actingAs($regular_user_creating_misc)
            ->visit('foorum/vaba-teema')
            ->click(trans('content.misc.create.title'))
            ->type('Hello misc title', 'title')
            ->type('Hello misc body', 'body')
            ->press(trans('content.create.submit.title'));

        $content = Content::whereTitle('Hello misc title')->first();

        $this->actingAs($regular_user_viewing_misc)
            ->visit("foorum/vaba-teema/$content->slug")
            ->see('Hello misc title')
            ->see('Hello misc body')
            ->dontSeeInElement('.MetaLink__title', trans('content.action.edit.title'));

        $response = $this->call('GET', "forum/$content->id/edit");

        $this->assertEquals(401, $response->status());
    }

    public function test_nonlogged_user_can_see_but_can_not_edit_other_blogs()
    {
        $regular_user_creating_misc = factory(User::class)->create();

        $this->actingAs($regular_user_creating_misc)
            ->visit('foorum/vaba-teema')
            ->click(trans('content.misc.create.title'))
            ->type('Hello misc title', 'title')
            ->type('Hello misc body', 'body')
            ->press(trans('content.create.submit.title'));

        $content = Content::whereTitle('Hello misc title')->first();

        Auth::logout();

        $this->visit("foorum/vaba-teema/$content->slug")
            ->see('Hello misc title')
            ->see('Hello misc body')
            ->dontSeeInElement('.MetaLink__title', trans('content.action.edit.title'));

        $response = $this->call('GET', "forum/$content->id/edit");
        
        $this->assertEquals(401, $response->status());
    }
}
