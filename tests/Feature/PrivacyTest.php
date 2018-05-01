<?php

namespace Tests\Feature;

use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PrivacyTest extends BrowserKitTestCase
{
    use DatabaseTransactions;

    public function test_unlogged_user_can_access_privacy_page()
    {
        $this
            ->visit('/')
            ->see('Privaatsustingimused')
            ->click('Privaatsustingimused')
            ->seePageIs('privaatsustingimused')
            ->see('Privaatsustingimused');
    }
}
