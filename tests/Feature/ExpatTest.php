<?php

namespace Tests\Feature;

use Auth;
use App\User;
use App\Content;
use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExpatTest extends BrowserKitTestCase
{
    use DatabaseTransactions;

    public function test_regular_user_can_create_expat_post()
    {
        $regular_user_creating_expat = factory(User::class)->create();

        $this->actingAs($regular_user_creating_expat)
            ->visit('foorum/elu-valimaal')
            ->click(trans('content.expat.create.title'))
            ->seePageIs('forum/create/expat')
            ->type('Hello expat title', 'title')
            ->type('Hello expat body', 'body')
            ->press(trans('content.create.submit.title'))
            ->seePageIs('foorum/elu-valimaal')
            ->see('Hello expat title')
            ->seeInDatabase('contents', [
                'user_id' => $regular_user_creating_expat->id,
                'title' => 'Hello expat title',
                'body' => 'Hello expat body',
                'type' => 'expat',
                'status' => 1,
            ]);

        $content = Content::whereTitle('Hello expat title')->first();

        $this->actingAs($regular_user_creating_expat)
            ->visit("foorum/elu-valimaal/$content->slug")
            ->click(trans('content.action.edit.title'))
            ->seePageIs("forum/$content->id/edit")
            ->type('Hola expat titulo', 'title')
            ->type('Hola expat cuerpo', 'body')
            ->press(trans('content.edit.submit.title'))
            ->seePageIs("foorum/uldfoorum/$content->slug") // FIXME
            ->see('Hola expat titulo')
            ->see('Hola expat cuerpo')
            ->seeInDatabase('contents', [
                'user_id' => $regular_user_creating_expat->id,
                'title' => 'Hola expat titulo',
                'body' => 'Hola expat cuerpo',
                'type' => 'expat',
                'status' => 1,
            ]);
    }

    public function test_regular_user_can_see_but_can_not_edit_other_expat_posts()
    {
        $regular_user_creating_expat = factory(User::class)->create();
        $regular_user_viewing_expat = factory(User::class)->create();

        $this->actingAs($regular_user_creating_expat)
            ->visit('foorum/elu-valimaal')
            ->click(trans('content.expat.create.title'))
            ->type('Hello expat title', 'title')
            ->type('Hello expat body', 'body')
            ->press(trans('content.create.submit.title'));

        $content = Content::whereTitle('Hello expat title')->first();

        $this->actingAs($regular_user_viewing_expat)
            ->visit("foorum/elu-valimaal/$content->slug")
            ->see('Hello expat title')
            ->see('Hello expat body')
            ->dontSeeInElement('.MetaLink__title', trans('content.action.edit.title'));

        $response = $this->call('GET', "forum/$content->id/edit");

        $this->assertEquals(401, $response->status());
    }

    public function test_nonlogged_user_can_see_but_can_not_edit_other_expat()
    {
        $regular_user_creating_expat = factory(User::class)->create();

        $this->actingAs($regular_user_creating_expat)
            ->visit('foorum/elu-valimaal')
            ->click(trans('content.expat.create.title'))
            ->type('Hello expat title', 'title')
            ->type('Hello expat body', 'body')
            ->press(trans('content.create.submit.title'));

        $content = Content::whereTitle('Hello expat title')->first();

        Auth::logout();

        $this->visit("foorum/elu-valimaal/$content->slug")
            ->see('Hello expat title')
            ->see('Hello expat body')
            ->dontSeeInElement('.MetaLink__title', trans('content.action.edit.title'));

        $response = $this->call('GET', "forum/$content->id/edit");
        
        $this->assertEquals(401, $response->status());
    }
}
