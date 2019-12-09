<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

use App\User;
use App\Offer;
use App\Destination;

class OffersAdminTest extends DuskTestCase
{
    protected $company_one;
    protected $company_two;
    protected $company_three;

    protected $other_company;

    protected $destination_tierra;
    protected $destination_sol;
    protected $destination_universo;

    protected $super_user;
    protected $admin_user;
    protected $regular_user;

    public function setUp()
    {
        parent::setUp();

        $this->company_one = factory(User::class)->create(['company' => true]);
        $this->company_two = factory(User::class)->create(['company' => true]);
        $this->company_three = factory(User::class)->create(['company' => true]);

        $this->destination_tierra = factory(Destination::class)->create(['name' => 'Tierra']);
        $this->destination_sol = factory(Destination::class)->create(['name' => 'Sol']);
        $this->destination_universo = factory(Destination::class)->create(['name' => 'Universo']);

        $this->other_company = factory(User::class)->create(['company' => true]);

        $this->regular_user = factory(User::class)->create();
        $this->admin_user = factory(User::class)->create(['role' => 'admin']);
        $this->super_user = factory(User::class)->create(['role' => 'superuser']);
    }

    public function test_company_can_not_add_offer_without_required_fields()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->company_one)
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
    }

    public function test_company_can_add_published_package_offer()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->company_two)
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

        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/logout')
                ->visit('/offer')
                ->pause(500)
                ->click(dusk('Playa Bonita para Mamacita'))
                ->assertSee('Playa Bonita para Mamacita')
                ->assertSee('2000€');
        });
    }

    public function test_company_can_add_unpublished_adventure_offer()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->company_three)
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

        $this->browse(function (Browser $browser) use ($offer) {
            $browser
                ->loginAs($this->company_three)
                ->visit("/offer/$offer->id")
                ->assertSee('Montaña alta para gringo')
                ->assertSee('See reisipakkumine pole avalikustatud');
        });

        // Assert superuser sees unpublished content

        $this->browse(function (Browser $browser) use ($offer) {
            $browser
                ->loginAs($this->super_user)
                ->visit("/offer/$offer->id")
                ->assertSee('Montaña alta para gringo')
                ->assertSee('See reisipakkumine pole avalikustatud');
        });

        // Assert other company do not see other company unpublished offer

        $this->browse(function (Browser $browser) use ($offer) {
            $browser
                ->loginAs($this->other_company)
                ->visit("/offer/$offer->id")
                ->assertSee('Õigused puuduvad')
                ->assertDontSee('Montaña alta para gringo');
        });

        // Assert regular user do not unpublished offer

        $regular_user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($offer) {
            $browser
                ->loginAs($this->regular_user)
                ->visit("/offer/$offer->id")
                ->assertSee('Õigused puuduvad')
                ->assertDontSee('Montaña alta para gringo');
        });

        // Assert admin user do not see unpublished offer

        $this->browse(function (Browser $browser) use ($offer) {
            $browser
                ->loginAs($this->admin_user)
                ->visit("/offer/$offer->id")
                ->assertSee('Õigused puuduvad')
                ->assertDontSee('Montaña alta para gringo');
        });

        $this->browse(function (Browser $browser) use ($offer) {
            $browser
                ->logout()
                ->visit('/')
                ->visit("/offer/$offer->id")
                ->assertSee('Pead esmalt sisse logima')
                ->assertDontSee('Montaña alta para gringo');
        });
    }

    public function tearDown()
    {
        if ($offer_first = Offer::whereTitle('Playa Bonita para Mamacita')->first()) {
            $offer_first->delete();
        }

        if ($offer_first = Offer::whereTitle('Montaña alta para gringo')->first()) {
            $offer_first->delete();
        }

        $this->company_one->delete();
        $this->company_two->delete();
        $this->company_three->delete();

        $this->destination_tierra->delete();
        $this->destination_sol->delete();
        $this->destination_universo->delete();

        $this->other_company->delete();
        $this->regular_user->delete();
        $this->admin_user->delete();
        $this->super_user->delete();
    }
}
