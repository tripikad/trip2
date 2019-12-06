<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

use App\User;
use App\Offer;

class OffersAdminTest extends DuskTestCase
{
    // public function test_company_can_not_add_offer_without_required_fields()
    // {
    //     $company = factory(User::class)->create(['company' => true]);

    //     $this->browse(function (Browser $browser) use ($company) {
    //         $browser
    //             ->loginAs($company)
    //             ->visit('/offer/admin/company')
    //             ->assertSourceHas('Minu reisipakkumised')
    //             ->click(dusk('Lisa paketireis'))
    //             ->assertPathIs('/offer/admin/create/package')
    //             ->scrollToDusk('Lisa paketireis')
    //             ->pause(500)
    //             ->click(dusk('Lisa paketireis'))
    //             ->assertPathIs('/offer/admin/create/package')
    //             ->assertSourceHas('Väli nimega "Pealkiri" on kohustuslik')
    //             ->assertSourceHas('Väli nimega "Reisi sihtkohad" on kohustuslik');
    //     });

    //     $company->delete();
    // }

    public function test_company_can_add_offer()
    {
        $company = factory(User::class)->create(['company' => true]);

        $this->browse(function (Browser $browser) use ($company) {
            $browser
                ->loginAs($company)
                ->visit('/offer/admin/company')
                ->assertSourceHas('Minu reisipakkumised')
                ->click(dusk('Lisa paketireis'))
                ->type(dusk('Pealkiri'), 'Playa Bonita para Mamacita')
                ->click(dusk('Reisi alguskoht'))
                ->keys(dusk('Reisi alguskoht'), 'Helsingi', '{enter}')
                ->click(dusk('Reisi sihtkohad'))
                ->keys(dusk('Reisi sihtkohad'), 'Mexico City', '{enter}')
                ->check(dusk('Transfeer hinna sees'))
                ->type(dusk('Hotelli nimi 1'), 'Hotel El Dorado')
                ->type(dusk('Hotelli hind 1'), '2000')
                ->scrollToDusk('Lisa paketireis')
                ->pause(500)
                ->click(dusk('Lisa paketireis'))
                ->assertPathIs('/offer/admin/company')
                ->assertSourceHas('Playa Bonita para Mamacita')
                ->assertSourceHas('Mexico City');
        });

        $offer = Offer::whereTitle('Playa Bonita para Mamacita')->first();

        $this->browse(function (Browser $browser) use ($company, $offer) {
            $browser
                ->loginAs($company)
                ->visit("/offer/$offer->id")
                ->screenshot('a')
                ->assertSourceHas('Playa Bonita para Mamacita');
        });
    }

    //                ->assertPathIs('/offer/admin/create/package')
    // ->scrollToDusk('Lisa paketireis')
    // ->pause(500)
    // ->click(dusk('Lisa paketireis'))
    // ->assertPathIs('/offer/admin/create/package')
    // ->assertSourceHas('Väli nimega "Pealkiri" on kohustuslik')
    // ->assertSourceHas('Väli nimega "Reisi sihtkohad" on kohustuslik')
    // ->click(dusk('Pealkiri'))
    //              ->type(dusk('Pealkiri'), 'Playa Bonita')
    // ->click(dusk('Reisi alguskoht'))
    // ->keys(dusk('Reisi alguskoht'), 'Helsingi', '{enter}')
    // ->click(dusk('Reisi sihtkohad'))
    // ->keys(dusk('Reisi sihtkohad'), 'Mexico City', '{enter}')
    // // ->check(dusk('Transfeer hinna sees'))
    // ->type(dusk('Hotelli nimi 1'), 'Hotel El Dorado')
    // ->type(dusk('Hotelli hind 1'), '2000')
    // ->type('input[name=start_destination]', '2')
    //->check('input[name=flghts]')
    // ->type('input[hotel_name[]]', 'Hotel El Dorado')
    //     });
    // }
}
