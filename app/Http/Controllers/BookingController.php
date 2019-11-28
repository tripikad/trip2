<?php

namespace App\Http\Controllers;

use Mail;

use App\Offer;
use App\Mail\OfferBooking;

class BookingController extends Controller
{
    public function create($id)
    {
        $user = auth()->user();

        $offer = Offer::find($id);

        // $booking = request()->only('name', 'email', 'phone', 'adults', 'children', 'notes');

        // $booking['insurance'] = request()->get('insurance') == 'on';
        // $booking['installments'] = request()->get('installments') == 'on';
        // $booking['flexible'] = request()->get('flexible') == 'on';

        $bookingData = [
            'name' => request()->name,
            'user_id' => $user ? $user->id : null,
            'data' => [
                'email' => request()->email,
                'phone' => request()->phone,
                'adults' => request()->adult,
                'children' => request()->children,
                'notes' => request()->notes
            ]
        ];

        $booking = $offer->bookings()->create($bookingData);

        Mail::to($offer->companyemail)->queue(new OfferBooking($offer, (object) $booking));

        return redirect()
            ->route('offer.index')
            ->with('info', 'The booking was sent');
    }
}
