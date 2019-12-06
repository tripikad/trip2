<?php

namespace Tests\Feature;

use App\Offer;
use App\User;
use App\Booking;

use App\Mail\CreateBooking;

use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;

class BookingTest extends BrowserKitTestCase
{
    use DatabaseTransactions;

    public function test_anoymous_user_can_see_offers()
    {
        Mail::fake();

        $company = factory(User::class)->create(['company' => true]);
        $offer = factory(Offer::class)->create(['user_id' => $company->id]);

        $this->visit("/offer/$offer->id")->dontSee('Broneeri reis');

        Mail::assertNotQueued(CreateBooking::class);
    }

    public function test_superuser_can_book_offers()
    {
        Mail::fake();

        $superuser = factory(User::class)->create(['role' => 'superuser']);
        $company = factory(User::class)->create(['company' => true]);
        $offer = factory(Offer::class)->create(['user_id' => $company->id]);

        $this->actingAs($superuser)
            ->visit("/offer/$offer->id")
            ->type('Ramon Alcazar', 'name')
            ->type('ramon@alcazar.es', 'email')
            ->type('+12345678', 'phone')
            ->press('Broneeri reis')
            ->seePageIs('/offer');

        // Verify the booking was saved to a database

        $booking = Booking::where('data->phone', '+12345678')->first();

        $this->assertTrue($booking !== null, 'Can not find booking by phone number');
        $this->assertTrue($booking->data->name == 'Ramon Alcazar', 'Name on the booking is incorrect');

        // Verify the booking was sent to a company by e-mail

        Mail::assertQueued(CreateBooking::class, function ($mail) use ($offer) {
            $mail->build();
            $this->assertTrue($mail->hasTo($offer->user->email), 'Unexpected to');
            $this->assertTrue($mail->subject == 'Ramon Alcazar broneeris reisi ' . $offer->title, 'Unexpected subject');
            return true;
        });
    }
}
