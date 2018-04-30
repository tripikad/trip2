<?php

namespace Tests\Browser;

use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class NavbarTest extends DuskTestCase
{
    public function test_unlogged_user_can_see_login_menu()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->click('.NavbarDesktop__linkMytrip')
                ->assertSeeIn('.NavbarDesktop__popover', 'Logi sisse')
                ->clickLink('Logi sisse')
                ->assertPathIs('/login');
        });
    }

    public function test_unlogged_user_can_see_register_menu()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->click('.NavbarDesktop__linkMytrip')
                ->assertSeeIn('.NavbarDesktop__popover', 'Registreeri')
                ->clickLink('Registreeri')
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
                ->click('.NavbarDesktop__userImage')
                ->assertSeeIn('.NavbarDesktop__popover', 'Profiil')
                ->clickLink('Profiil')
                ->assertPathIs("/user/$regular_user->id");
        });

        $regular_user->delete();
    }
}
