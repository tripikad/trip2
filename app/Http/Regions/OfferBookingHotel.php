<?php

namespace App\Http\Regions;

class OfferBookingHotel
{
    public function render($offer)
    {
        return component('FormAccordion')
            ->height(49)
            ->is('large')
            ->withName('hotel')
            ->withValue(old('hotel', collect($offer->data->hotels)->count()))
            ->withItems(
                collect()
                    ->push(
                        component('Body')
                            ->withBody('Jätan hotelli valimata')
                            ->render()
                    )
                    ->merge(
                        collect($offer->data->hotels)->map(function ($hotel) use ($offer) {
                            $hotel->price = format_currency($hotel->price);
                            $query = urlencode(
                                collect()
                                    ->push($hotel->name)
                                    ->push('hotel')
                                    ->push(
                                        $offer
                                            ->endDestinations()
                                            ->pluck('name')
                                            ->implode(' ')
                                    )
                                    ->implode('+')
                            );
                            $hotel->url = 'https://www.tripadvisor.com/Search?ssrc=h&&q=' . $query;
                            $hotel->urlTitle = trans('offer.book.hotel.url');
                            $stars = intval(only_numbers($hotel->rating));
                            if ($stars > 0) {
                                $hotel->rating = implode('', array_fill(0, $stars, '★'));
                            }
                            return component('HotelRow')
                                ->withHotel($hotel)
                                ->render();
                        })
                    )
            );
    }
}
