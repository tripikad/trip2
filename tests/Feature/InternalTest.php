<?php

namespace Tests\Feature;

use Auth;
use App\User;
use App\Content;
use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class InternalTest extends BrowserKitTestCase
{
    use DatabaseTransactions;

    public function test_admin_user_can_create_and_edit_internal()
    {
        $admin_user_creating_internal = factory(User::class)->create(['role' => 'admin']);

        $this->actingAs($admin_user_creating_internal)
            ->visit('internal')
            ->click(trans('content.internal.create.title'))
            ->seePageIs('internal/create')
            ->type('Hello internal title', 'title')
            ->type('Hello internal body', 'body')
            ->press(trans('content.create.submit.title'))
            ->seePageIs('internal')
            ->see('Hello internal title')
            ->seeInDatabase('contents', [
                'user_id' => $admin_user_creating_internal->id,
                'title' => 'Hello internal title',
                'body' => 'Hello internal body',
                'type' => 'internal',
                'status' => 1,
            ]);

        $content = Content::whereTitle('Hello internal title')->first();

        $this->actingAs($admin_user_creating_internal)
            ->visit("internal/$content->id")
            ->click(trans('content.action.edit.title'))
            ->seePageIs("internal/$content->id/edit")
            ->type('Hola blog titulo', 'title')
            ->type('Hola blog cuerpo', 'body')
            ->press(trans('content.edit.submit.title'))
            ->seePageIs("internal/$content->id")
            ->see('Hola blog titulo')
            ->see('Hola blog cuerpo')
            ->seeInDatabase('contents', [
                'user_id' => $admin_user_creating_internal->id,
                'title' => 'Hola blog titulo',
                'body' => 'Hola blog cuerpo',
                'type' => 'internal',
                'status' => 1,
            ]);
    }

    public function test_regular_users_can_not_see_and_edit_internal()
    {
        $admin_user_creating_internal = factory(User::class)->create(['role' => 'admin']);
        $regular_user_viewing_internal = factory(User::class)->create();

        $this->actingAs($admin_user_creating_internal)
                ->visit('internal')
                ->click(trans('content.internal.create.title'))
                ->type('Hello internal title', 'title')
                ->type('Hello internal body', 'body')
                ->press(trans('content.create.submit.title'));

        $content = Content::whereTitle('Hello internal title')->first();

        $this->actingAs($regular_user_viewing_internal);

        $view_response = $this->call('GET', "internal/$content->id");
        $this->assertEquals(401, $view_response->status());

        $edit_response = $this->call('GET', "internal/$content->id/edit");
        $this->assertEquals(401, $edit_response->status());
    }

    public function test_nonlogged_users_can_not_see_and_edit_internal()
    {
        $admin_user_creating_internal = factory(User::class)->create(['role' => 'admin']);

        $this->actingAs($admin_user_creating_internal)
                ->visit('internal')
                ->click(trans('content.internal.create.title'))
                ->type('Hello internal title', 'title')
                ->type('Hello internal body', 'body')
                ->press(trans('content.create.submit.title'));

        $content = Content::whereTitle('Hello internal title')->first();

        Auth::logout();

        $view_response = $this->call('GET', "internal/$content->id");
        $this->assertEquals(401, $view_response->status());

        $edit_response = $this->call('GET', "internal/$content->id/edit");
        $this->assertEquals(401, $edit_response->status());
    }
}
