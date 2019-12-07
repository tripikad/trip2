<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

use App\User;
use App\Offer;
use App\Destination;

class OffersAdminTest extends DuskTestCase
{
  public function test_unlogged_users_can_not_access_offer_admin()
  {
    $this->browse(function (Browser $browser) {
      $browser
        ->visit('/offer/admin')
        ->assertSourceHas('Pead esmalt sisse logima')
        ->assertSourceMissing('Kõik reisipakkumised')
        ->assertSourceMissing('Lisa seiklusreis')
        ->visit('/offer/admin/company')
        ->assertSourceHas('Pead esmalt sisse logima')
        ->assertSourceMissing('Reisipakkumiste lisamine')
        ->assertSourceMissing('Lisa seiklusreis');
    });
  }

  public function test_regular_users_can_not_access_offer_admin()
  {
    $regular_user = factory(User::class)->create();

    $this->browse(function (Browser $browser) use ($regular_user) {
      $browser
        ->loginAs($regular_user)
        ->visit('/offer/admin')
        ->assertSourceHas('Õigused puuduvad')
        ->assertSourceMissing('Kõik reisipakkumised')
        ->assertSourceMissing('Lisa seiklusreis')
        ->visit('/offer/admin/company')
        ->assertSourceHas('Õigused puuduvad')
        ->assertSourceMissing('Minu reisipakkumised')
        ->assertSourceMissing('Lisa seiklusreis');
    });

    $regular_user->delete();
  }

  public function test_admin_users_can_not_access_offer_admin()
  {
    $admin_user = factory(User::class)->create(['role' => 'admin']);

    $this->browse(function (Browser $browser) use ($admin_user) {
      $browser
        ->loginAs($admin_user)
        ->visit('/offer/admin')
        ->assertSourceHas('Õigused puuduvad')
        ->assertSourceMissing('Kõik reisipakkumised')
        ->assertSourceMissing('Lisa seiklusreis')
        ->visit('/offer/admin/company')
        ->assertSourceHas('Õigused puuduvad')
        ->assertSourceMissing('Minu reisipakkumised')
        ->assertSourceMissing('Lisa seiklusreis');
    });

    $admin_user->delete();
  }

  public function test_company_can_not_add_offer_without_required_fields()
  {
    $company = factory(User::class)->create(['company' => true]);

    $this->browse(function (Browser $browser) use ($company) {
      $browser
        ->loginAs($company)
        ->visit('/offer/admin/company')
        ->assertSourceHas('Reisipakkumiste lisamine')
        ->click(dusk('Lisa paketireis'))
        ->assertPathIs('/offer/admin/create/package')
        ->scrollToBottom()
        ->pause(1000)
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

    $destination1 = factory(Destination::class)->create(['name' => 'Tierra']);
    $destination2 = factory(Destination::class)->create(['name' => 'Sol']);

    $this->browse(function (Browser $browser) use ($company) {
      $browser
        ->loginAs($company)
        ->visit('/offer/admin/company')
        ->assertSourceHas('Reisipakkumiste lisamine')
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
        ->assertPathIs('/offer/admin/company')
        ->assertSourceHas('Playa Bonita para Mamacita')
        ->assertSourceHas('2000€')
        ->assertSourceHas('Sol');
    });

    // Assert users can see the offer without being logged in

    $offer = Offer::whereTitle('Playa Bonita para Mamacita')->first();

    $this->browse(function (Browser $browser) use ($company, $offer) {
      $browser
        ->logout()
        ->visit('/offer')
        ->pause(500)
        ->click(dusk('Playa Bonita para Mamacita'))
        ->assertPathIs("/offer/$offer->id")
        ->assertSourceHas('2000€')
        ->assertSourceHas('Paketireis');
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
        ->visit('/offer/admin/company')
        ->assertSourceHas('Reisipakkumiste lisamine')
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
        ->assertPathIs('/offer/admin/company')
        ->assertSourceHas('Montaña alta para gringo')
        ->assertSourceHas('Universo');
    });

    $offer = Offer::whereTitle('Montaña alta para gringo')->first();

    // Assert company does not not see it's own unpublished content
    // @TODO2 Give ability to preview

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

    $destination1->delete();
    $destination2->delete();
    $offer->delete();
    $company->delete();
    $other_company->delete();
  }
}
