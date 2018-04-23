<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class FrontpageTest extends DuskTestCase
{
    public function testFrontpage()
    {
        dump(env('APP_URL'));
        $this->browse(function (Browser $browser) {
            dump($browser);
            $browser->visit('/')
                //->assertSourceHas('Autoriõigused');
                ->dump();
        });
    }

    // public function testFrontpageJS()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/')
    //             ->whenAvailable('.FrontpageSearch__input', function ($search) {
    //                 $search->assertSourceHas('Kuhu sa soovid minna?');
    //             }, 10);
    //     });
    // }
}
