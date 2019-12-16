<?php

namespace Tests\Feature;

use Auth;
use App\User;
use App\Content;
use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BlogTest extends BrowserKitTestCase
{
    use DatabaseTransactions;

    public function test_regular_user_can_create_and_edit_blog()
    {
        $regular_user_creating_blog = factory(User::class)->create();

        $this->actingAs($regular_user_creating_blog)
            ->visit('reisikirjad')
            ->click(trans('content.blog.create.title'))
            ->seePageIs('blog/create')
            ->type('Hello blog title', 'title')
            ->type('Hello blog body', 'body')
            ->press(trans('content.create.submit.title'))
            ->seePageIs('reisikirjad')
            ->see('Hello blog title')
            ->see('Hello blog body')
            ->seeInDatabase('contents', [
                'user_id' => $regular_user_creating_blog->id,
                'title' => 'Hello blog title',
                'body' => 'Hello blog body',
                'type' => 'blog',
                'status' => 1
            ]);

        $content = Content::whereTitle('Hello blog title')->first();

        $this->actingAs($regular_user_creating_blog)
            ->visit("reisikirjad/$content->slug")
            ->click(trans('content.action.edit.title'))
            ->seePageIs("blog/$content->id/edit")
            ->type('Hola blog titulo', 'title')
            ->type('Hola blog cuerpo', 'body')
            ->press(trans('content.edit.submit.title'))
            ->seePageIs("reisikirjad/$content->slug")
            ->see('Hola blog titulo')
            ->see('Hola blog cuerpo')
            ->seeInDatabase('contents', [
                'user_id' => $regular_user_creating_blog->id,
                'title' => 'Hola blog titulo',
                'body' => 'Hola blog cuerpo',
                'type' => 'blog',
                'status' => 1
            ]);
    }

    public function test_regular_user_can_see_but_can_not_edit_other_blogs()
    {
        $regular_user_creating_blog = factory(User::class)->create();
        $regular_user_viewing_blog = factory(User::class)->create();

        $this->actingAs($regular_user_creating_blog)
            ->visit('reisikirjad')
            ->click(trans('content.blog.create.title'))
            ->type('Hello blog title', 'title')
            ->type('Hello blog body', 'body')
            ->press(trans('content.create.submit.title'));

        $content = Content::whereTitle('Hello blog title')->first();

        $this->actingAs($regular_user_viewing_blog)
            ->visit("reisikirjad/$content->slug")
            ->see('Hello blog title')
            ->see('Hello blog body')
            ->dontSeeInElement('.MetaLink__title', trans('content.action.edit.title'));

        $response = $this->call('GET', "blog/$content->id/edit");

        $this->assertEquals(401, $response->status());
    }

    public function test_nonlogged_user_can_see_but_can_not_edit_other_blogs()
    {
        $regular_user_creating_blog = factory(User::class)->create();

        $this->actingAs($regular_user_creating_blog)
            ->visit('content/blog')
            ->click(trans('content.blog.create.title'))
            ->type('Hello blog title', 'title')
            ->type('Hello blog body', 'body')
            ->press(trans('content.create.submit.title'));

        $content = Content::whereTitle('Hello blog title')->first();

        Auth::logout();

        $this->visit("content/blog/$content->id")
            ->see('Hello blog title')
            ->see('Hello blog body')
            ->dontSeeInElement('.MetaLink__title', trans('content.action.edit.title'));

        $response = $this->call('GET', "blog/$content->id/edit");
        $this->assertEquals(401, $response->status());
    }
}
