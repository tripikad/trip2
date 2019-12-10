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
                    // ->push(
                    //     component('Section')
                    //         ->withPadding(2)
                    //         ->withTag('header')
                    //         ->withBackground('blue')
                    //         ->withItems(collect()->push(region('NavbarLight')))
                    // )
                    ->push(
                        component('Section')
                            ->withBackground('blue')
                            ->withPadding(10)
                            ->withAlign('center')
                            ->withWidth(styles('tablet-width'))
                            ->withItems(
                                collect()
                                    // ->push(
                                    //     component('Title')
                                    //         ->is('large')
                                    //         ->is('white')
                                    //         ->is('center')
                                    //         ->with('title', trans('offer.index'))
                                    // )
                                    ->push(
                                        component('OfferList')
                                            ->with('height', '200vh')
                                            ->with('route', route('offer.index.json'))
                                            ->with('user_id', $user ? $user->id : '')
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
            ->latest()
            ->with(['user:id,name', 'startDestinations', 'endDestinations'])
            ->paginate(3);

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

        return layout('Full')
            ->withHeadRobots('noindex')
            ->withTitle($offer->title)
            ->withItems(
                collect()
                    ->pushWhen(
                        $offer->status == 0,
                        component('HeaderUnpublished')->with('title', trans('offer.show.unpublished'))
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
                                            ->with('title', 'Kõik reisipakkumised')
                                            ->with('route', route('offer.index'))
                                    )
                                    ->push(region('OfferMap', $offer))
                                    ->push(
                                        component('Flex')->with(
                                            'items',
                                            $offer->endDestinations->map(function ($destination) {
                                                return component('Tag')
                                                    ->is('large')
                                                    ->is('white')
                                                    ->with('title', $destination->name);
                                            })
                                        )
                                    )
                                    ->spacer()
                                    ->push(
                                        component('Title')
                                            ->is('large')
                                            ->is('white')
                                            ->with('title', $offer->title . ' ' . $offer->price)
                                    )
                                    ->push(region('OfferDuration', $offer))
                                    ->spacer()
                                    ->push(region('OfferDetails', $offer))
                                    ->spacer()
                                    ->pushWhen(
                                        $user && $user->hasRole('superuser'),
                                        component('Button')
                                            ->is('orange')
                                            ->is('large')
                                            ->with('title', trans('offer.show.book'))
                                            ->with('route', route('offer.show', [$id]) . '#book')
                                    )
                                    ->spacer(2)
                            )
                    )
                    ->push(region('PhotoSection', $photos))
                    ->pushWhen(
                        $offer->data->description ||
                            $offer->data->included ||
                            $offer->data->notincluded ||
                            $offer->data->extras,
                        component('Section')
                            ->withDimmed($offer->status == 0)
                            ->withPadding(4)
                            ->withGap(1)
                            ->withItems(
                                collect()
                                    ->pushWhen(
                                        $offer->data->description,
                                        component('Body')
                                            ->is('responsive')
                                            ->with('body', format_body($offer->data->description))
                                    )
                                    ->spacer(2)
                                    ->pushWhen(
                                        $offer->data->included || $offer->data->notincluded || $offer->data->extras,
                                        region('OfferConditions', $offer)
                                    )
                            )
                    )
                    ->push('<a id="book"></a>')
                    ->pushWhen(
                        $user && $user->hasRole('superuser'),
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
                                            ->withTitle(trans('offer.show.book'))
                                    )
                            )
                    )
                    ->pushWhen(
                        $user && $user->hasRole('superuser'),
                        component('Section')
                            ->withDimmed($offer->status == 0)
                            ->withWidth(styles('mobile-large-width'))
                            ->withBackground('blue')
                            ->withInnerBackground('white')
                            ->withInnerPadding(2)
                            ->withItems(region('OfferBooking', $id, $name, $email))
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
