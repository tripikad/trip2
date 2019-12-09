<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

use App\User;
use App\Offer;
use App\Destination;

class OffersAdminTest extends DuskTestCase
{
    public function test_company_can_not_add_offer_without_required_fields()
    {
        $company = factory(User::class)->create(['company' => true]);

        $this->browse(function (Browser $browser) use ($company) {
            $browser
                ->loginAs($company)
                ->visit('/company')
                ->assertSee('Halda reisipakkumisi')
                ->click(dusk('Lisa paketireis'))
                ->assertPathIs('/offer/admin/create/package')
                ->scrollToBottom()
                ->pause(1000)
                ->click(dusk('Lisa paketireis'))
                ->assertPathIs('/offer/admin/create/package')
                ->assertSee('Väli nimega "Pealkiri" on kohustuslik')
                ->assertSee('Väli nimega "Reisi sihtkohad" on kohustuslik');
        });

        $company->delete();
    }

    public function test_company_can_add_published_package_offer()
    {
        $company = factory(User::class)->create(['company' => true]);

        $destination1 = factory(Destination::class)->create(['name' => 'Tierra']);
        $destination2 = factory(Destination::class)->create(['name' => 'Sol']);

        $this->browse(function (Browser $browser) use ($company) {
            $browser
                ->loginAs($company)
                ->visit('/company')
                ->assertSee('Halda reisipakkumisi')
                ->click(dusk('Lisa paketireis'))
                ->click(dusk('Pakkumine on avalikustatud'))
                ->type(dusk('Pealkiri'), 'Playa Bonita para Mamacita')
                ->click(dusk('Reisi alguskoht'))
                ->keys(dusk('Reisi alguskoht'), 'Tierra', '{enter}')
                ->click(dusk('Reisi sihtkohad'))
                ->keys(dusk('Reisi sihtkohad'), 'Sol', '{enter}')
                ->click(dusk('Transfeer hinna sees'))
                ->type(dusk('Hotelli nimi 1'), 'Hotel El Dorado')
                ->type(dusk('Hotelli hind 1'), '2000')
                ->scrollToBottom()
                ->pause(1000)
                ->click(dusk('Lisa paketireis'))
                ->assertPathIs('/company')
                ->assertSee('Playa Bonita para Mamacita')
                ->assertSee('2000€')
                ->assertSee('Sol');
        });

        // Assert users can see the offer without being logged in

        $offer = Offer::whereTitle('Playa Bonita para Mamacita')->first();

        $this->browse(function (Browser $browser) use ($company, $offer) {
            $browser
                ->visit('/logout')
                ->visit('/offer')
                ->pause(500)
                ->click(dusk('Playa Bonita para Mamacita'))
                ->assertPathIs("/offer/$offer->id")
                ->assertSee('2000€')
                ->assertSee('Paketireis');
        });

        // Cleanup

        $destination1->delete();
        $destination2->delete();
        $offer->delete();
        $company->delete();

        $this->assertTrue(Offer::whereTitle('Playa Bonita para Mamacita')->first() == null);
        $this->assertTrue(User::whereName($company->name)->first() == null);
    }

    public function test_company_can_add_unpublished_adventure_offer()
    {
        $company = factory(User::class)->create(['company' => true]);

        $destination1 = factory(Destination::class)->create(['name' => 'Sol']);
        $destination2 = factory(Destination::class)->create(['name' => 'Universo']);

        $this->browse(function (Browser $browser) use ($company) {
            $browser
                ->loginAs($company)
                ->visit('/company')
                ->assertSee('Halda reisipakkumisi')
                ->click(dusk('Lisa seiklusreis'))
                ->pause(1000)
                ->type(dusk('Pealkiri'), 'Montaña alta para gringo')
                ->click(dusk('Reisi alguskoht'))
                ->keys(dusk('Reisi alguskoht'), 'Sol', '{enter}')
                ->click(dusk('Reisi sihtkohad'))
                ->keys(dusk('Reisi sihtkohad'), 'Universo', '{enter}')
                ->scrollToBottom()
                ->pause(1000)
                ->click(dusk('Lisa seiklusreis'))
                ->assertPathIs('/company')
                ->assertSee('Montaña alta para gringo')
                ->assertSee('Universo');
        });

        $offer = Offer::whereTitle('Montaña alta para gringo')->first();

        // Assert company sees its own unpublished content

        $this->browse(function (Browser $browser) use ($company, $offer) {
            $browser
                ->visit('/logout')
                ->loginAs($company)
                ->visit('/company')
                ->visit("/offer/$offer->id")
                ->assertSee('Montaña alta para gringo')
                ->assertSee('See reisipakkumine pole avalikustatud');
        });

        // Assert companies do not see each other unpublished offers

        // $other_company = factory(User::class)->create(['company' => true]);

        // $this->browse(function (Browser $browser) use ($other_company) {
        //     $browser
        //         ->loginAs($other_company)
        //         ->visit("/offer/$offer->id")
        //         ->assertDontSee('Montaña alta para gringo');
        // });

        // Cleanup

        $destination1->delete();
        $destination2->delete();
        $offer->delete();
        $company->delete();
        //$other_company->delete();
    }
}
