<?php

namespace Tests\Feature;

use Auth;
use App\User;
use App\Content;
use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BuysellTest extends BrowserKitTestCase
{
  use DatabaseTransactions;

  public function test_regular_user_can_create_buysell_post()
  {
    // Vue: EditorComment\EditorComment conflict - BrowserKit cannot find body input element.
    $this->markTestSkipped();

    $regular_user_creating_buysell = factory(User::class)->create();

    $this->actingAs($regular_user_creating_buysell)
      ->visit('foorum/ost-muuk')
      ->click(trans('content.buysell.create.title'))
      ->seePageIs('forum/create/buysell')
      ->type('Hello buysell title', 'title')
      ->type('Hello buysell body', 'body')
      ->press(trans('content.create.submit.title'))
      ->seePageIs('foorum/ost-muuk')
      ->see('Hello buysell title')
      ->seeInDatabase('contents', [
        'user_id' => $regular_user_creating_buysell->id,
        'title' => 'Hello buysell title',
        'body' => 'Hello buysell body',
        'type' => 'buysell',
        'status' => 1
      ]);

    $content = Content::whereTitle('Hello buysell title')->first();

    $this->actingAs($regular_user_creating_buysell)
      ->visit("foorum/ost-muuk/$content->slug")
      ->click(trans('content.action.edit.title'))
      ->seePageIs("forum/$content->id/edit")
      ->type('Hola buysell titulo', 'title')
      ->type('Hola buysell cuerpo', 'body')
      ->press(trans('content.edit.submit.title'))
      ->seePageIs("foorum/uldfoorum/$content->slug") // FIXME
      ->see('Hola buysell titulo')
      ->see('Hola buysell cuerpo')
      ->seeInDatabase('contents', [
        'user_id' => $regular_user_creating_buysell->id,
        'title' => 'Hola buysell titulo',
        'body' => 'Hola buysell cuerpo',
        'type' => 'buysell',
        'status' => 1
      ]);
  }

  public function test_regular_user_can_see_but_can_not_edit_other_buysell_posts()
  {
    // Vue: EditorComment\EditorComment conflict - BrowserKit cannot find body input element.
    $this->markTestSkipped();

    $regular_user_creating_buysell = factory(User::class)->create();
    $regular_user_viewing_buysell = factory(User::class)->create();

    $this->actingAs($regular_user_creating_buysell)
      ->visit('foorum/ost-muuk')
      ->click(trans('content.buysell.create.title'))
      ->type('Hello buysell title', 'title')
      ->type('Hello buysell body', 'body')
      ->press(trans('content.create.submit.title'));

    $content = Content::whereTitle('Hello buysell title')->first();

    $this->actingAs($regular_user_viewing_buysell)
      ->visit("foorum/ost-muuk/$content->slug")
      ->see('Hello buysell title')
      ->see('Hello buysell body')
      ->dontSeeInElement('.MetaLink__title', trans('content.action.edit.title'));

    $response = $this->call('GET', "forum/$content->id/edit");

    $this->assertEquals(401, $response->status());
  }

  public function test_nonlogged_user_can_see_but_can_not_edit_other_blogs()
  {
    // Vue: EditorComment\EditorComment conflict - BrowserKit cannot find body input element.
    $this->markTestSkipped();

    $regular_user_creating_buysell = factory(User::class)->create();

    $this->actingAs($regular_user_creating_buysell)
      ->visit('foorum/ost-muuk')
      ->click(trans('content.buysell.create.title'))
      ->type('Hello buysell title', 'title')
      ->type('Hello buysell body', 'body')
      ->press(trans('content.create.submit.title'));

    $content = Content::whereTitle('Hello buysell title')->first();

    Auth::logout();

    $this->visit("foorum/ost-muuk/$content->slug")
      ->see('Hello buysell title')
      ->see('Hello buysell body')
      ->dontSeeInElement('.MetaLink__title', trans('content.action.edit.title'));

    $response = $this->call('GET', "forum/$content->id/edit");

    $this->assertEquals(401, $response->status());
  }
}
