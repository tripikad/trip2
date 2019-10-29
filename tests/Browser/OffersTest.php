<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class OffersTest extends DuskTestCase
{
    public function test_everybody_can_see_offers_page()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/offers')
                ->assertSourceHas(trans('offers.index.title'));
        });
    }

    public function test_robots_can_not_index_offers_page()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/offers')
                ->assertSourceHas('meta name="robots" content="noindex"');
        });
    }
}
