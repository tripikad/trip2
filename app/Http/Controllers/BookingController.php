<?php

namespace App\Http\Controllers;

use Mail;

use App\Offer;
use App\Mail\CreateBooking;

class BookingController extends Controller
{
    public function create($id)
    {
        $user = auth()->user();

        $offer = Offer::find($id);

        // Rules
        // name: required?
        // email: email

        $bookingData = [
            'user_id' => $user ? $user->id : null,
            'data' => [
                'name' => request()->name,
                'email' => request()->email,
                'phone' => request()->phone,
                'adults' => request()->adults,
                'children' => request()->children,
                'notes' => request()->notes,
                'insurance' => request()->insurance == 'on',
                'installments' => request()->installments == 'on',
                'flexible' => request()->flexible == 'on'
            ]
        ];

        $booking = $offer->bookings()->create($bookingData);

        // return new CreateBooking($offer, $booking);

        Mail::to($booking->data->email)->queue(new CreateBooking($offer, $booking));

        return redirect()
            ->route('offer.index')
            ->with('info', 'The booking was sent');
    }
}
