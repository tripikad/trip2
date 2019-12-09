<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

use App\User;

class CompanyTest extends DuskTestCase
{
    protected $regular_user;
    protected $admin_user;
    protected $super_user;

    public function setUp()
    {
        parent::setUp();

        $this->regular_user = factory(User::class)->create();
        $this->admin_user = factory(User::class)->create(['role' => 'admin']);
        $this->super_user = factory(User::class)->create(['role' => 'superuser']);
    }

    public function test_unlogged_users_can_not_access_company_and_company_admin_page()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/company')
                ->assertSee('Pead esmalt sisse logima')
                ->assertDontSee('Halda reisipakkumisi')
                ->assertDontSee('Lisa seiklusreis')
                ->visit('/company/admin')
                ->assertSee('Pead esmalt sisse logimaa')
                ->assertDontSee('Halda reisifirmasid');
        });
    }

    public function test_regular_users_can_not_access_offer_admin()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->regular_user)
                ->visit('/company')
                ->assertSee('Õigused puuduvad')
                ->assertDontSee('Halda reisipakkumisi')
                ->assertDontSee('Lisa seiklusreis')
                ->visit('/company/admin')
                ->assertSee('Õigused puuduvad')
                ->assertDontSee('Halda reisifirmasid');
        });
    }

    public function test_admin_users_can_not_access_offer_admin()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->admin_user)
                ->visit('/company')
                ->assertSee('Õigused puuduvad')
                ->assertDontSee('Halda reisipakkumisi')
                ->assertDontSee('Lisa seiklusreis')
                ->visit('/company/admin')
                ->assertSee('Õigused puuduvad')
                ->assertDontSee('Halda reisifirmasid');
        });
    }

    public function test_superuser_can_add_company_and_company_can_log_in_and_edit()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->super_user)
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

        $this->browse(function (Browser $browser) {
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
                ->click(dusk('Uuenda'));
        });
    }

    public function tearDown()
    {
        $this->regular_user->delete();
        $this->admin_user->delete();
        $this->super_user->delete();
    }
}
