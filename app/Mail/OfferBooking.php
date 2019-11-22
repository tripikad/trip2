<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OfferBooking extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $offer;

    public $booking;

    public function __construct(/* Offer */ $offer, $booking)
    {
        $this->offer = $offer;
        $this->booking = $booking;
    }

    public function build()
    {
        $this->subject(
            trans('offer.book.email.subject', [
                'title' => $this->offer->title,
                'name' => $this->booking->name
            ])
        )->markdown('email.offer.booking', [
            'offer' => $this->offer,
            'booking' => $this->booking,
            'offer_route' => route('offer.show', $this->offer->id)
        ]);

        $header = [
            'category' => ['offer_booking'],
            'unique_args' => [
                'offer_id' => (string) $this->offer->id,
                'booking_id' => (string) $this->booking->id
            ]
        ];

        $this->withSwiftMessage(function ($message) use ($header) {
            $message
                ->getHeaders()
                ->addTextHeader('X-SMTPAPI', format_smtp_header($header));
        });
    }
}
