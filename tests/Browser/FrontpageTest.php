<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class FrontpageTest extends DuskTestCase
{
    public function testFrontpage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->whenAvailable('.FrontpageSearch__input', function ($search) {
                    $search->assertSourceHas('Kuhu sa soovid minna?');
                });
        });
    }
}
