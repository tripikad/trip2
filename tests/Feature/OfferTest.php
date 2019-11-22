<?php

namespace Tests\Feature;

use App\Offer;
use App\Mail\OfferBooking;

use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;

class OfferTest extends BrowserKitTestCase
{
    use DatabaseTransactions;

    public function test_anoymous_user_can_see_and_book_offers()
    {
        Mail::fake();

        $offer = (new Offer())->find(1);

        $this->visit('offers/' . $offer->id)
            ->type('Ramon Alcazar', 'name')
            ->type('ramon@alcazar.es', 'email')
            ->type('+345678890', 'phone')
            ->type('1', 'adults')
            ->type('No hay', 'children')
            ->type('Soy una persona muy importante', 'notes')
            ->check('insurance')
            ->check('installments')
            ->check('flexible')
            ->press('Broneeri reis')
            ->seePageIs('offers');

        Mail::assertQueued(OfferBooking::class, function ($mail) use ($offer) {
            $mail->build();
            $this->assertTrue(
                $mail->hasTo($offer->companyemail),
                'Unexpected to'
            );
            $this->assertTrue(
                $mail->subject ==
                    'Ramon Alcazar broneeris reisi ' . $offer->title,
                'Unexpected subject'
            );
            return true;
        });
    }
}
