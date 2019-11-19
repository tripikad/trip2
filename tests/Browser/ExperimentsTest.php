<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class ExperimentsTest extends DuskTestCase
{
    public function test_anybody_can_see_components_page()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/experiments/components')
                ->assertSourceHas('Components')
                ->visit('/experiments/components?preview')
                ->assertSourceHas('Components');
        });
    }
}
