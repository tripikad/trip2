<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Content;
use App\User;

class FeedTest extends TestCase
{
    use DatabaseTransactions;

    public function test_unlogged_user_can_access_news_feed()
    {
        $contents = factory(Content::class, 15)->create([
                'user_id' => factory(User::class)->create()->id,
                'type' => 'news',
            ]);

        $this
            ->visit('/')
            ->click(trans('menu.footer3.newsfeed'))
            ->seePageIs('index.atom');

        foreach ($contents as $content) {
            $this->see($content->title);
        }
    }

    public function test_unlogged_user_can_access_flight_feed()
    {
        $contents = factory(Content::class, 15)->create([
            'user_id' => factory(User::class)->create()->id,
            'type' => 'flight',
        ]);

        $this
            ->visit('/')
            ->click(trans('menu.footer3.flightfeed'))
            ->seePageIs('lendude_sooduspakkumised/rss');

        foreach ($contents as $content) {
            $this->see($content->title);
        }
    }
}
