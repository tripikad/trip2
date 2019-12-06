<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

use App\User;
use App\Offer;

class OffersAdminTest extends DuskTestCase
{
    public function test_company_can_not_add_offer_without_required_fields()
    {
        $company = factory(User::class)->create(['company' => true]);

        $this->browse(function (Browser $browser) use ($company) {
            $browser
                ->loginAs($company)
                ->visit('/offer/admin/company')
                ->assertSourceHas('Minu reisipakkumised')
                ->click(dusk('Lisa paketireis'))
                ->assertPathIs('/offer/admin/create/package')
                ->scrollToDusk('Lisa paketireis')
                ->pause(500)
                ->click(dusk('Lisa paketireis'))
                ->assertPathIs('/offer/admin/create/package')
                ->assertSourceHas('Väli nimega "Pealkiri" on kohustuslik')
                ->assertSourceHas('Väli nimega "Reisi sihtkohad" on kohustuslik');
        });

        $company->delete();
    }

    public function test_company_can_add_published_package_offer()
    {
        $company = factory(User::class)->create(['company' => true]);

        $this->browse(function (Browser $browser) use ($company) {
            $browser
                ->loginAs($company)
                ->visit('/offer/admin/company')
                ->assertSourceHas('Minu reisipakkumised')
                ->click(dusk('Lisa paketireis'))
                ->check(dusk('Pakkumine on avalikustatud'))
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
                ->assertSourceHas('2000€')
                ->assertSourceHas('Mexico City');
        });

        // Assert users can see the offer without being logged in

        $offer = Offer::whereTitle('Playa Bonita para Mamacita')->first();

        $this->browse(function (Browser $browser) use ($company, $offer) {
            $browser
                ->logout()
                ->visit("/offer/$offer->id")
                ->assertSourceHas('Playa Bonita para Mamacita')
                ->assertSourceHas('2000€')
                ->assertSourceHas('Paketireis')
                ->logout();
        });

        // Cleanup

        $offer->delete();
        $company->delete();

        $this->assertTrue(Offer::whereTitle('Playa Bonita para Mamacita')->first() == null);
        $this->assertTrue(User::whereName($company->name)->first() == null);
    }

    public function test_company_can_add_unpublished_adventure_offer()
    {
        $company = factory(User::class)->create(['company' => true]);

        $this->browse(function (Browser $browser) use ($company) {
            $browser
                ->loginAs($company)
                ->visit('/offer/admin/company')
                ->assertSourceHas('Minu reisipakkumised')
                ->click(dusk('Lisa seiklusreis'))
                ->type(dusk('Pealkiri'), 'Montaña alta para gringo')
                ->type(dusk('Hind'), '3000')
                ->click(dusk('Reisi alguskoht'))
                ->keys(dusk('Reisi alguskoht'), 'Stockholm', '{enter}')
                ->click(dusk('Reisi sihtkohad'))
                ->keys(dusk('Reisi sihtkohad'), 'Peruu', '{enter}')
                ->click(dusk('Reisi sihtkohad'))
                ->keys(dusk('Reisi sihtkohad'), 'Boliivia', '{enter}')
                ->scrollToDusk('Lisa seiklusreis')
                ->pause(500)
                ->click(dusk('Lisa seiklusreis'))
                ->assertPathIs('/offer/admin/company')
                ->assertSourceHas('Montaña alta para gringo')
                ->assertSourceHas('3000€')
                ->assertSourceHas('Peruu')
                ->assertSourceHas('Boliivia');
        });

        $offer = Offer::whereTitle('Montaña alta para gringo')->first();

        $this->browse(function (Browser $browser) use ($company, $offer) {
            $browser
                ->loginAs($company)
                ->visit("/offer/$offer->id")
                ->assertSourceHas('Suure tõenäosusega on lehekülg liigutatud teise kohta')
                ->assertSourceMissing('Montaña alta para gringo');
        });

        // Assert companies do not see each other unpublished offers

        $other_company = factory(User::class)->create(['company' => true]);

        $this->browse(function (Browser $browser) use ($other_company) {
            $browser
                ->loginAs($other_company)
                ->visit('/offer/admin/company')
                ->assertSourceMissing('Montaña alta para gringo');
        });

        // Cleanup

        $offer->delete();
        $company->delete();
        $other_company->delete();
    }
}
