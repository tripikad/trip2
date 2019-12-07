<?php

namespace App\Http\Controllers;

use LVR\Phone\Phone;
use Mail;

use App\Offer;

use App\Mail\CreateBooking;

class BookingController extends Controller
{
    public function create($id)
    {
        $user = auth()->user();

        $offer = Offer::findOrFail($id);

        $rules = [
      'phone' => ['required', new Phone()],
      'email' => 'email'
    ];

        $this->validate(request(), $rules);

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

        Mail::to($offer->user->email)->queue(new CreateBooking($offer, $booking));

        return redirect()
      ->route('offer.index')
      ->with('info', 'The booking was sent');
    }
}
