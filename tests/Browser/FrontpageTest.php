<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class FrontpageTest extends DuskTestCase
{
    public function test_frontpage_html_content_is_displayed()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSourceHas('Autoriõigused');
        });
    }

    public function test_frontpage_js_content_is_displayed()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->whenAvailable('.FrontpageSearch__input', function ($search) {
                    $search->assertSourceHas('Kuhu sa soovid minna?');
                });
        });
    }
}
