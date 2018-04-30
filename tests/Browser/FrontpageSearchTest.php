<?php

namespace Tests\Browser;

use App\Content;
use App\Searchable;
use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FrontpageSearchTest extends DuskTestCase
{
    public function test_anybody_can_search_in_frontpage()
    {
        $regular_user = factory(User::class)->create();

        $content = factory(Content::class)->create([
            'user_id' => factory(User::class)->create()->id,
            'type' => 'forum',
            'title' => 'Donde esta nuestra playa',
        ]);

        Searchable::unguard();

        $searchable = Searchable::create([
            'user_id' => $content->user->id,
            'content_id' => $content->id,
            'content_type' => $content->type,
            'comment_id' => null,
            'destination_id' => null,
            'title' => $content->title,
            'body' => $content->body,
            'created_at' => $content->created_at,
            'updated_at' => $content->updated_at,
        ]);

        Searchable::reguard();

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(100)
                ->assertSourceHas('Kuhu sa soovid minna?')
                ->type('.FrontpageSearch__input', 'Donde esta nuestra playa')
                ->pause(500)
                ->assertSeeIn('.FrontpageSearch__results', 'Donde esta nuestra playa')
                ->click('.FrontpageSearchItem')
                ->assertPathBeginsWith('/foorum/uldfoorum/');
        });

        $searchable->delete();
        $content->delete();
        $regular_user->delete();
    }
}
