<?php

namespace Tests\Feature;

use Auth;
use App\User;
use App\Content;
use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FlightTest extends BrowserKitTestCase
{
  use DatabaseTransactions;

  public function test_admin_user_can_create_and_edit_flight()
  {
    $admin_user_creating_flight = factory(User::class)->create(['role' => 'admin']);

    $this->actingAs($admin_user_creating_flight)
      ->visit('odavad-lennupiletid')
      ->click(trans('content.flight.create.title'))
      ->seePageIs('flight/create')
      ->type('Hello flight title', 'title')
      ->type('Hello flight body', 'body')
      ->press(trans('content.create.submit.title'))
      ->seePageIs('odavad-lennupiletid')
      ->see('Hello flight title')
      ->seeInDatabase('contents', [
        'user_id' => $admin_user_creating_flight->id,
        'title' => 'Hello flight title',
        'body' => 'Hello flight body',
        'type' => 'flight',
        'status' => 1
      ]);

    $content = Content::whereTitle('Hello flight title')->first();

    $this->actingAs($admin_user_creating_flight)
      ->visit("odavad-lennupiletid/$content->slug")
      ->click(trans('content.action.edit.title'))
      ->seePageIs("flight/$content->id/edit")
      ->type('Hola flight titulo', 'title')
      ->type('Hola flight cuerpo', 'body')
      ->press(trans('content.edit.submit.title'))
      ->seePageIs("odavad-lennupiletid/$content->slug")
      ->see('Hola flight titulo')
      ->see('Hola flight cuerpo')
      ->seeInDatabase('contents', [
        'user_id' => $admin_user_creating_flight->id,
        'title' => 'Hola flight titulo',
        'body' => 'Hola flight cuerpo',
        'type' => 'flight',
        'status' => 1
      ]);
  }

  public function test_regular_users_can_not_see_and_edit_unpublished_flight()
  {
    $admin_user_creating_flight = factory(User::class)->create(['role' => 'admin']);
    $regular_user_viewing_flight = factory(User::class)->create();

    $this->actingAs($admin_user_creating_flight)
      ->visit('odavad-lennupiletid')
      ->click(trans('content.flight.create.title'))
      ->type('Hello flight title', 'title')
      ->type('Hello flight body', 'body')
      ->press(trans('content.create.submit.title'));

    $content = Content::whereTitle('Hello flight title')->first();

    $this->actingAs($regular_user_viewing_flight)
      ->visit("odavad-lennupiletid/$content->slug")
      ->seePageIs("odavad-lennupiletid/$content->slug")
      ->see('Hello flight title');

    $edit_response = $this->call('GET', "flight/$content->id/edit");
    $this->assertEquals(401, $edit_response->status());
  }

  public function test_nonlogged_users_can_not_see_and_edit_unpublished_flight()
  {
    $admin_user_creating_flight = factory(User::class)->create(['role' => 'admin']);

    $this->actingAs($admin_user_creating_flight)
      ->visit('odavad-lennupiletid')
      ->click(trans('content.flight.create.title'))
      ->type('Hello flight title', 'title')
      ->type('Hello flight body', 'body')
      ->press(trans('content.create.submit.title'));

    $content = Content::whereTitle('Hello flight title')->first();

    Auth::logout();

    $this->visit("odavad-lennupiletid/$content->slug")
      ->seePageIs("odavad-lennupiletid/$content->slug")
      ->see('Hello flight title');

    $edit_response = $this->call('GET', "flight/$content->id/edit");
    $this->assertEquals(401, $edit_response->status());
  }
}
