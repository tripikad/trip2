<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

use App\User;
use App\Offer;
use App\Destination;

class CompanyTest extends DuskTestCase
{
    public function test_unlogged_users_can_not_access_company_and_company_admin_page()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/company')
                ->asserSee('Pead esmalt sisse logima')
                ->assertDontSee('Halda reisipakkumisi')
                ->assertDontSee('Lisa seiklusreis')
                ->visit('/company/admin')
                ->asserSee('Pead esmalt sisse logima')
                ->assertDontSee('Halda reisifirmasid');
        });
    }

    public function test_regular_users_can_not_access_offer_admin()
    {
        $regular_user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($regular_user) {
            $browser
                ->loginAs($regular_user)
                ->visit('/company')
                ->asserSee('Õigused puuduvad')
                ->assertDontSee('Halda reisipakkumisi')
                ->assertDontSee('Lisa seiklusreis')
                ->visit('/company/admin')
                ->asserSee('Õigused puuduvad')
                ->assertDontSee('Halda reisifirmasid');
        });

        $regular_user->delete();
    }

    public function test_admin_users_can_not_access_offer_admin()
    {
        $admin_user = factory(User::class)->create(['role' => 'admin']);

        $this->browse(function (Browser $browser) use ($admin_user) {
            $browser
                ->loginAs($admin_user)
                ->visit('/company')
                ->asserSee('Õigused puuduvad')
                ->assertDontSee('Halda reisipakkumisi')
                ->assertDontSee('Lisa seiklusreis')
                ->visit('/company/admin')
                ->asserSee('Õigused puuduvad')
                ->assertDontSee('Halda reisifirmasid');
        });

        $admin_user->delete();
    }

    public function test_superuser_can_add_company_and_company_can_log_in_and_edit()
    {
        $superuser = factory(User::class)->create(['role' => 'superuser']);

        $this->browse(function (Browser $browser) use ($superuser) {
            $browser
                ->loginAs($superuser)
                ->visit('/company/create')
                ->assertSee('Lisa reisifirma')
                ->type(dusk('Kasutajanimi'), 'empresariarica')
                ->type(dusk('Firmanimi'), 'Empresaria Rica')
                ->type(dusk('Parool'), 'nomedemihijo')
                ->type(dusk('Korda parooli'), 'nomedemihijo')
                ->type(dusk('E-mail'), 'empresaria@rica.es')
                //->attach('file', './storage/tests/test.jpg')
                ->scrollToBottom()
                ->pause(500)
                ->click(dusk('Lisa reisifirma'));
        });

        $this->browse(function (Browser $browser) use ($superuser) {
            $browser
                ->visit('/logout')
                ->visit('/login')
                ->type(dusk('Kasutajanimi'), 'empresariarica')
                ->type(dusk('Parool'), 'nomedemihijo')
                ->click(dusk('Logi sisse'))
                ->visit('/company')
                ->click(dusk('Muuda profiili'))
                ->assertSee('Uuenda firma profiili')
                ->type(dusk('Kasutajanimi'), 'vagabundopobre')
                ->type(dusk('Firmanimi'), 'Vagabundo Pobre')
                ->type(dusk('Uus parool'), 'nomedemihija')
                ->type(dusk('Korda parooli'), 'nomedemihija')
                //->attach('file', './storage/tests/test.jpg')
                ->scrollToBottom()
                ->pause(500)
                ->click(dusk('Uuendaa'))
                ->screenshot('a');
        });
    }
}
