<?php

namespace Tests\Feature;

use App\User;
use App\Content;
use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FeedTest extends BrowserKitTestCase
{
  use DatabaseTransactions;

  public function test_unlogged_user_can_access_news_feed()
  {
    $contents = factory(Content::class, 15)->create([
      'user_id' => factory(User::class)->create()->id,
      'type' => 'news'
    ]);

    // Testing Footer

    $this->visit('/')
      ->click(trans('menu.footer-social.newsfeed'))
      ->seePageIs('index.atom');

    foreach ($contents as $content) {
      $this->see($content->title);
    }
  }

  public function test_unlogged_user_can_access_flight_feed()
  {
    $contents = factory(Content::class, 15)->create([
      'user_id' => factory(User::class)->create()->id,
      'type' => 'flight'
    ]);

    // Testing Footer

    $this->visit('/')
      ->click(trans('menu.footer-social.flightfeed'))
      ->seePageIs('lendude_sooduspakkumised/rss');

    foreach ($contents as $content) {
      $this->see($content->title);
    }
  }
}
