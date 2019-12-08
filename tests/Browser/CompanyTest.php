<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

use App\User;
use App\Offer;
use App\Destination;

class CompanyTest extends DuskTestCase
{
    public function test_superuser_can_add_company_and_company_can_log_in()
    {

        $superuser = factory(User::class)->create(['role' => 'superuser']);

        $this->browse(function (Browser $browser) use ($superuser) {
            $browser
                ->loginAs($superuser)
                ->visit('/company/create')
                ->assertSourceHas('Lisa reisifirma')
                ->type(dusk('Kasutajanimi'), 'empresariarica')
                ->type(dusk('Firmanimi'), 'Empresaria Rica')
                ->type(dusk('Parool'), 'nomedemihijo')
                ->type(dusk('Parool uuesti'), 'nomedemihijo')
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
                ->visit('/offer/admin/company')
                ->assertSourceHas('Lisa seiklusreis');
        });
    }
}