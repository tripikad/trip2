<?php

namespace Tests\Feature;

use Auth;
use App\User;
use App\Content;
use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShortnewsTest extends BrowserKitTestCase
{
    use DatabaseTransactions;

    public function test_admin_user_can_create_and_edit_shortnews()
    {
        $admin_user_creating_shortnews = factory(User::class)->create(['role' => 'admin']);

        $this->actingAs($admin_user_creating_shortnews)
            ->visit('uudised')
            ->click(trans('content.news.create.title'))
            ->seePageIs('news/create')
            ->select('shortnews', 'type')
            ->type('Hello shortnews title', 'title')
            ->type('Hello shortnews body', 'body')
            ->press(trans('content.create.submit.title'))
            ->seeInDatabase('contents', [
                'user_id' => $admin_user_creating_shortnews->id,
                'title' => 'Hello shortnews title',
                'body' => 'Hello shortnews body',
                'type' => 'shortnews',
                'status' => 0
            ]);

        $content = Content::whereTitle('Hello shortnews title')->first();

        $this->seePageIs("uudised/$content->slug");

        $this->actingAs($admin_user_creating_shortnews)
            ->visit("uudised/$content->slug")
            ->click(trans('content.action.edit.title'))
            ->seePageIs("news/$content->id/edit")
            ->type('Hola shortnews titulo', 'title')
            ->type('Hola shortnews cuerpo', 'body')
            ->press(trans('content.edit.submit.title'))
            ->seePageIs("uudised/$content->slug")
            ->see('Hola shortnews titulo')
            ->see('Hola shortnews cuerpo')
            ->seeInDatabase('contents', [
                'user_id' => $admin_user_creating_shortnews->id,
                'title' => 'Hola shortnews titulo',
                'body' => 'Hola shortnews cuerpo',
                'type' => 'shortnews',
                'status' => 0
            ]);
    }

    public function test_regular_users_can_not_see_and_edit_unpublished_shortnews()
    {
        $admin_user_creating_shortnews = factory(User::class)->create(['role' => 'admin']);
        $regular_user_viewing_shortnews = factory(User::class)->create();

        $this->actingAs($admin_user_creating_shortnews)
            ->visit('uudised')
            ->click(trans('content.news.create.title'))
            ->type('Hello shortnews title', 'title')
            ->type('Hello shortnews body', 'body')
            ->press(trans('content.create.submit.title'));

        $content = Content::whereTitle('Hello shortnews title')->first();

        $this->actingAs($regular_user_viewing_shortnews);

        $view_response = $this->call('GET', "news/$content->id");
        $this->assertEquals(404, $view_response->status());

        $edit_response = $this->call('GET', "news/$content->id/edit");
        $this->assertEquals(401, $edit_response->status());
    }

    public function test_nonlogged_users_can_not_see_and_edit_unpublished_shortnews()
    {
        $admin_user_creating_shortnews = factory(User::class)->create(['role' => 'admin']);

        $this->actingAs($admin_user_creating_shortnews)
            ->visit('uudised')
            ->click(trans('content.news.create.title'))
            ->type('Hello shortnews title', 'title')
            ->type('Hello shortnews body', 'body')
            ->press(trans('content.create.submit.title'));

        $content = Content::whereTitle('Hello shortnews title')->first();

        Auth::logout();

        $view_response = $this->call('GET', "news/$content->id");
        $this->assertEquals(404, $view_response->status());

        $edit_response = $this->call('GET', "news/$content->id/edit");
        $this->assertEquals(401, $edit_response->status());
    }
}
