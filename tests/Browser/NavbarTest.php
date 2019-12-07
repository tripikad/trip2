<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class NavbarTest extends DuskTestCase
{
    public function test_unlogged_user_can_see_login_menu()
    {
        $this->browse(function (Browser $browser) {
            $browser
        ->visit('/')
        ->click('.NavbarDesktop__linkMytrip')
        ->pause(500)
        ->assertSeeIn('.NavbarDesktop__popover', 'Logi sisse')
        ->clickLink('Logi sisse') // @todo make sure it's JS link
        ->assertPathIs('/login');
        });
    }

    public function test_unlogged_user_can_see_register_menu()
    {
        $this->browse(function (Browser $browser) {
            $browser
        ->visit('/')
        ->pause(500)
        ->click('.NavbarDesktop__linkMytrip')
        ->pause(500)
        ->assertSeeIn('.NavbarDesktop__popover', 'Registreeri')
        ->clickLink('Registreeri') // @todo make sure it's JS link
        ->assertPathIs('/register');
        });
    }

    public function test_logged_user_can_see_profile_menu()
    {
        $regular_user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($regular_user) {
            $browser
        ->loginAs($regular_user) // @todo replace with browser login
        ->visit('/')
        ->pause(500)
        ->click('.NavbarDesktop__userImage')
        ->pause(500)
        ->assertSeeIn('.NavbarDesktop__popover', 'Profiil')
        ->clickLink('Profiil') // @todo make sure it's JS link
        ->assertPathIs("/user/$regular_user->id");
        });

        $regular_user->delete();
    }
}
