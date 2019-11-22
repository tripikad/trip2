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

    public $user;

    public function __construct(/* Offer */ $offer, $booking, User $user)
    {
        $this->offer = $offer;
        $this->booking = $booking;
        $this->user = $user;
    }

    public function build()
    {
        $this->subject(
            trans('offer.book.email.subject', [
                'title' => $this->offer->title,
                'name' => $this->booking->name
            ])
        )->markdown('email.booking', [
            'offer' => $this->offer,
            'booking' => $this->booking,
            'user' => $this->user
        ]);

        $header = [
            'category' => ['offer_booking'],
            'unique_args' => [
                'offer_id' => (string) $this->offer->id,
                'booking_id' => $this->booking->id,
                'user_id' => $this->user->id
            ]
        ];

        $this->withSwiftMessage(function ($message) use ($header) {
            $message
                ->getHeaders()
                ->addTextHeader('X-SMTPAPI', format_smtp_header($header));
        });
    }
}
