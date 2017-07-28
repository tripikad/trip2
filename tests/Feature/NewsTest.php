<?php

namespace Tests\Feature;

use Auth;
use App\User;
use App\Content;
use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewsTest extends BrowserKitTestCase
{
    use DatabaseTransactions;

    public function test_admin_user_can_create_and_edit_news()
    {
        $admin_user_creating_news = factory(User::class)->create(['role' => 'admin']);

        $this->actingAs($admin_user_creating_news)
            ->visit('uudised')
            ->click(trans('content.news.create.title').' (beta)') // FIXME
            ->seePageIs('news/create2') // FIXME
            ->type('Hello news title', 'title')
            ->type('Hello news body', 'body')
            ->press(trans('content.create.submit.title'))
            ->seeInDatabase('contents', [
                'user_id' => $admin_user_creating_news->id,
                'title' => 'Hello news title',
                'body' => 'Hello news body',
                'type' => 'news',
                'status' => 0,
            ]);

        $content = Content::whereTitle('Hello news title')->first();

        $this->seePageIs("uudised/$content->slug");

        $this->actingAs($admin_user_creating_news)
            ->visit("uudised/$content->slug")
            ->click(trans('content.action.edit.title'))
            ->seePageIs("news/$content->id/edit")
            ->type('Hola news titulo', 'title')
            ->type('Hola news cuerpo', 'body')
            ->press(trans('content.edit.submit.title'))
            ->seePageIs("uudised/$content->slug")
            ->see('Hola news titulo')
            ->see('Hola news cuerpo')
            ->seeInDatabase('contents', [
                'user_id' => $admin_user_creating_news->id,
                'title' => 'Hola news titulo',
                'body' => 'Hola news cuerpo',
                'type' => 'news',
                'status' => 0,
            ]);
    }

    public function test_regular_users_can_not_see_and_edit_unpublished_news()
    {
        $admin_user_creating_news = factory(User::class)->create(['role' => 'admin']);
        $regular_user_viewing_news = factory(User::class)->create();

        $this->actingAs($admin_user_creating_news)
                ->visit('uudised')
                ->click(trans('content.news.create.title').' (beta)') // FIXME
                ->type('Hello news title', 'title')
                ->type('Hello news body', 'body')
                ->press(trans('content.create.submit.title'));

        $content = Content::whereTitle('Hello news title')->first();

        $this->actingAs($regular_user_viewing_news);

        $view_response = $this->call('GET', "news/$content->id");
        $this->assertEquals(404, $view_response->status());

        $edit_response = $this->call('GET', "news/$content->id/edit");
        $this->assertEquals(401, $edit_response->status());
    }

    public function test_nonlogged_users_can_not_see_and_edit_unpublished_news()
    {
        $admin_user_creating_news = factory(User::class)->create(['role' => 'admin']);

        $this->actingAs($admin_user_creating_news)
                ->visit('uudised')
                ->click(trans('content.news.create.title').' (beta)') // FIXME
                ->type('Hello news title', 'title')
                ->type('Hello news body', 'body')
                ->press(trans('content.create.submit.title'));

        $content = Content::whereTitle('Hello news title')->first();

        Auth::logout();

        $view_response = $this->call('GET', "news/$content->id");
        $this->assertEquals(404, $view_response->status());

        $edit_response = $this->call('GET', "news/$content->id/edit");
        $this->assertEquals(401, $edit_response->status());
    }
}
