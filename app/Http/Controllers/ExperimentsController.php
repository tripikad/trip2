<?php

namespace App\Http\Controllers;

use App\Offer;

class ExperimentsController extends Controller
{
    public function index()
    {
        $user = null;

        $offer = Offer::find(7);

        return layout('Full')
            ->withItems(
                component('Section')
                    ->padding(10)
                    ->withWidth(styles('mobile-large-width'))
                    ->height('100vh')
                    ->withBackground('blue')
                    ->withInnerBackground('white')
                    ->withInnerPadding(2)
                    ->withItems(
                        component('FormAccordion')
                            ->is('large')
                            ->withItems(
                                collect($offer->data->hotels)
                                    ->map(function ($hotel) use ($offer) {
                                        $hotel->price = format_currency($hotel->price);
                                        $query = urlencode(
                                            $hotel->name .
                                                ' ' .
                                                $offer
                                                    ->endDestinations()
                                                    ->pluck('name')
                                                    ->implode(' ')
                                        );
                                        $hotel->url = 'https://www.tripadvisor.com/Search?q=' . $query;
                                        $hotel->urlTitle = trans('offer.book.hotel.url');
                                        $stars = intval(only_numbers($hotel->rating));
                                        if ($stars > 0) {
                                            $hotel->rating = implode('', array_fill(0, $stars, '★'));
                                        }
                                        return component('HotelRow')
                                            ->withHotel($hotel)
                                            ->render();
                                    })
                                    ->push('aaa')
                            )
                    )
            )
            ->render();
    }
}
