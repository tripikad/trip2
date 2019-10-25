<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class ComponentsTest extends DuskTestCase
{
    public function test_anybody_can_see_components_page()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/components')
                ->assertSourceHas('Components')
                ->visit('/components?preview')
                ->assertSourceHas('Components');
        });
    }
}
