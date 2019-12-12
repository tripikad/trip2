<?php

namespace App\Http\Controllers;

use App\Content;
use App\Offer;
use App\User;

class OfferController extends Controller
{
    public function index()
    {
        $user = null;

        if (request()->has('user_id')) {
            $user = User::whereCompany(true)->findOrFail(request()->user_id);
        }

        return layout('Full')
            ->withHeadRobots('noindex')
            ->withTransparency(true)
            ->withTitle(trans('offer.index'))
            ->withItems(
                collect()
                    ->push(
                        component('Section')
                            ->withPadding(2)
                            ->withTag('header')
                            ->withBackground('blue')
                            ->withItems(collect()->push(region('NavbarLight')))
                    )
                    ->push(
                        component('Section')
                            ->withBackground('blue')
                            ->withPadding(2)
                            ->withWidth(styles('tablet-width'))
                            ->withItems(
                                collect()
                                    ->push(
                                        component('Title')
                                            ->is('large')
                                            ->is('white')
                                            ->is('center')
                                            ->withTitle(trans('offer.index'))
                                    )
                                    ->push(
                                        component('OfferList')
                                            ->withHeight(100)
                                            ->withRoute(route('offer.index.json'))
                                            ->withSuffix(config('site.currency.eur'))
                                    )
                            )
                    )
                    ->push(
                        component('Section')
                            ->withTag('footer')
                            ->withBackground('blue')
                            ->withItems(collect()->push(region('FooterLight', '')))
                    )
            )
            ->render();
    }

    public function indexJson()
    {
        $data = Offer::public()
            ->orderBy('start_at')
            ->with(['user:id,name', 'startDestinations', 'endDestinations'])
            ->paginate(50);

        return response()->json($data);
    }

    public function show($id)
    {
        $user = auth()->user();
        $offer = Offer::findOrFail($id);

        if (!$user && $offer->status == 0) {
            return abort(401);
        }
        if ($user && $offer->status == 0 && !$user->hasRoleOrOwner('superuser', $offer->user->id)) {
            return abort(401);
        }

        $photos = Content::getLatestPagedItems('photo', 9, $offer->endDestinations->first()->id);

        $email = $user ? $user->email : '';
        $name = $user && $user->real_name ? $user->real_name : '';

        $isPackage = $offer->style == 'package';

        $hasContent =
            $offer->data->description || $offer->data->included || $offer->data->notincluded || $offer->data->extras;

        return layout('Full')
            ->withHeadRobots('noindex')
            ->withTitle($offer->title)
            ->withItems(
                collect()
                    ->pushWhen(
                        $offer->status == 0,
                        component('HeaderUnpublished')->withTitle(trans('offer.show.unpublished'))
                    )
                    ->push(
                        component('Section')
                            ->withPadding(2)
                            ->withTag('header')
                            ->withBackground('blue')
                            ->withItems(collect()->push(region('NavbarLight')))
                    )
                    ->push(
                        component('Section')
                            ->withDimmed($offer->status == 0)
                            ->withGap(1)
                            ->withAlign('center')
                            ->withBackground('blue')
                            ->withItems(
                                collect()
                                    ->push(
                                        component('Link')
                                            ->is('white')
                                            ->withTitle('Kõik reisipakkumised')
                                            ->withRoute(route('offer.index'))
                                    )
                                    ->push(region('OfferMap', $offer))
                                    ->push(
                                        component('Flex')->with(
                                            'items',
                                            $offer->endDestinations->map(function ($destination) {
                                                return component('Tag')
                                                    ->is('large')
                                                    ->is('white')
                                                    ->withTitle($destination->name);
                                            })
                                        )
                                    )
                                    ->spacer()
                                    ->push(
                                        component('Title')
                                            ->is('large')
                                            ->is('white')
                                            ->is('center')
                                            ->withTitle($offer->title . ' ' . $offer->price_formatted)
                                    )
                                    ->push(region('OfferDuration', $offer))
                                    ->spacer()
                                    ->push(region('OfferDetails', $offer))
                                    ->spacer(2)
                                    ->pushWhen(
                                        // @LAUNCH Remove user control
                                        $isPackage && $user && $user->hasRole('superuser'),
                                        component('Button')
                                            ->is('orange')
                                            ->is('large')
                                            ->withTitle(trans('offer.show.book'))
                                            ->withRoute(route('offer.show', [$id]) . '#book')
                                    )
                                    ->spacerWhen($isPackage && $offer->data->url, 1)
                                    ->pushWhen(
                                        $isPackage && $offer->data->url,
                                        component('Button')
                                            ->is('blue')
                                            ->withExternal(true)
                                            ->withTitle(trans('offer.show.goto'))
                                            ->withRoute(route('booking.goto', [$id]))
                                    )
                                    ->pushWhen(
                                        !$isPackage && $offer->data->url,
                                        component('Button')
                                            ->is('orange')
                                            ->is('large')
                                            ->withExternal(true)
                                            ->withTitle(trans('offer.show.goto'))
                                            ->withRoute(route('booking.goto', [$id]))
                                    )
                                    ->spacer(3)
                            )
                    )
                    ->push(region('PhotoSection', $photos))
                    ->pushWhen(
                        $hasContent,
                        component('Section')
                            ->withDimmed($offer->status == 0)
                            ->withPadding(2)
                            ->withGap(1)
                            ->withItems(
                                collect()
                                    ->spacer(2)
                                    ->pushWhen(
                                        $offer->data->description,
                                        component('Body')
                                            ->is('responsive')
                                            ->with('body', format_body($offer->data->description))
                                    )
                                    ->spacerWhen($offer->data->description, 2)
                                    ->pushWhen(
                                        $offer->data->included || $offer->data->notincluded || $offer->data->extras,
                                        region('OfferConditions', $offer)
                                    )
                            )
                    )

                    ->pushWhen($isPackage, '<a id="book"></a>')
                    ->pushWhen(
                        // @LAUNCH remove user control
                        $isPackage && $user && $user->hasRole('superuser'),
                        component('Section')
                            ->withDimmed($offer->status == 0)
                            ->withPadding(2)
                            ->withBackground('blue')
                            ->withAlign('center')
                            ->withItems(
                                collect()
                                    ->spacer(2)
                                    ->push(
                                        component('Title')
                                            ->is('white')
                                            ->withTitle(trans('offer.show.book.title'))
                                    )
                            )
                    )
                    ->pushWhen(
                        // @LAUNCH remove user control
                        $isPackage && $user && $user->hasRole('superuser'),
                        component('Section')
                            ->withDimmed($offer->status == 0)
                            ->withWidth(styles('mobile-large-width'))
                            ->withBackground('blue')
                            ->withInnerBackground('white')
                            ->withInnerPadding(2)
                            ->withItems(region('OfferBooking', $id, $name, $email))
                    )
                    ->pushWhen(
                        $hasContent && !$isPackage,
                        component('Section')
                            ->withDimmed($offer->status == 0)
                            ->withAlign('center')
                            ->withPadding(3)
                            ->withItems(
                                component('Button')
                                    ->is('orange')
                                    ->is('large')
                                    ->withExternal(true)
                                    ->withTitle(trans('offer.show.goto'))
                                    ->withRoute(route('booking.goto', [$id]))
                            )
                    )
                    ->push(
                        component('Section')
                            ->withTag('footer')
                            ->withBackground('blue')
                            ->withItems(collect()->push(region('FooterLight', '')))
                    )
            )
            ->render();
    }
}
