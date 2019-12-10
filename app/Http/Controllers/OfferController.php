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

        return layout('Offer')
            ->with('color', 'blue')
            ->with('head_robots', 'noindex')
            ->with(
                'header',
                region(
                    'OfferHeader',
                    collect()->push(
                        component('Title')
                            ->is('large')
                            ->is('white')
                            ->is('center')
                            ->with('title', trans('offer.index'))
                    )
                )
            )
            ->with(
                'content',
                collect()->push(
                    component('OfferList')
                        ->with('height', '200vh')
                        ->with('route', route('offer.index.json'))
                        ->with('user_id', $user ? $user->id : '')
                )
            )
            ->with('footer', region('FooterLight', ''))
            ->render();
    }

    public function indexJson()
    {
        $data = Offer::public()
            ->latest()
            ->with(['user:id,name', 'startDestinations', 'endDestinations'])
            ->get()
            ->map(function ($offer) {
                $offer->route = route('offer.show', $offer);
                return $offer;
            });

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
            ->withTransparency(true)
            ->withTitle('Offer')
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
                                            ->is('semitransparent')
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
                    ->push(
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
                                    ->push(region('OfferConditions', $offer))
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

    public function show2($id)
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

        return layout('Offer')
            ->with('head_robots', 'noindex')
            ->with('title', 'Offer')
            ->with('color', 'blue')
            ->with('header', region('OfferHeader'))
            ->with(
                'top',
                collect()
                    ->pushWhen(
                        !$offer->status,
                        component('HeaderUnpublished')->with('title', trans('offer.show.unpublished'))
                    )
                    ->pushWhen(!$offer->status, '&nbsp;')
                    ->push(
                        component('Center')->with(
                            'item',
                            component('Link')
                                ->is('white')
                                ->is('semitransparent')
                                ->with('title', 'Kõik reisipakkumised')
                                ->with('route', route('offer.index'))
                        )
                    )
                    ->push(
                        component('Dotmap')
                            ->is('center')
                            ->with('height', '300px')
                            ->with('destination_facts', config('destination_facts'))

                            ->with('lines', [
                                $offer->startDestinations
                                    ->first()
                                    ->vars()
                                    ->coordinates(),
                                $offer->endDestinations
                                    ->first()
                                    ->vars()
                                    ->coordinates()
                            ])
                            ->with('mediumdots', [
                                $offer->startDestinations
                                    ->first()
                                    ->vars()
                                    ->coordinates()
                            ])
                            ->with('largedots', [
                                $offer->endDestinations
                                    ->first()
                                    ->vars()
                                    ->coordinates()
                            ])
                    )
                    ->push(
                        component('Flex')
                            ->with('justify', 'center')
                            ->with(
                                'items',
                                $offer->endDestinations->map(function ($destination) {
                                    return component('Tag')
                                        ->is('large')
                                        ->is('white')
                                        ->with('title', $destination->name);
                                })
                            )
                    )
                    ->push(
                        component('Title')
                            ->is('large')
                            ->is('white')
                            ->is('center')
                            ->with('title', $offer->title . ' ' . $offer->price)
                    )
                    ->push(region('OfferDuration', $offer))
                    ->spacer()
                    ->push(region('OfferDetails', $offer))
                    ->pushWhen(
                        $photos->count(),
                        region('PhotoRow', $photos->count() < 18 ? $photos->slice(0, 9) : $photos)
                    )
                    ->spacer()
                    ->push(
                        component('Title')
                            ->is('small')
                            ->is('white')
                            ->is('center')
                            ->with('title', trans('offer.show.description'))
                    )
                    ->push(
                        '<div style="padding: 0 10vw">' .
                            component('Body')
                                ->is('white')
                                ->with('body', format_body($offer->data->description)) .
                            '</div>'
                    )
                    ->push(
                        component('Title')
                            ->is('small')
                            ->is('white')
                            ->is('center')
                            ->with('title', trans('offer.show.accommodation'))
                    )
                    ->push(
                        '<div style="padding: 0 10vw">' .
                            component('Body')
                                ->is('white')
                                ->with('body', format_body($offer->data->accommodation)) .
                            '</div>'
                    )
                    ->push(
                        component('Title')
                            ->is('small')
                            ->is('white')
                            ->is('center')
                            ->with('title', trans('offer.show.included'))
                    )
                    ->push(
                        '<div style="padding: 0 10vw">' .
                            component('Body')
                                ->is('white')
                                ->with('body', format_body($offer->data->included)) .
                            '</div>'
                    )
                    ->push(
                        component('Title')
                            ->is('small')
                            ->is('white')
                            ->is('center')
                            ->with('title', trans('offer.show.notincluded'))
                    )
                    ->push(
                        '<div style="padding: 0 10vw">' .
                            component('Body')
                                ->is('white')
                                ->with('body', format_body($offer->data->notincluded)) .
                            '</div>'
                    )
                    ->push(
                        component('Title')
                            ->is('small')
                            ->is('white')
                            ->is('center')
                            ->with('title', trans('offer.show.extras'))
                    )
                    ->push(
                        '<div style="padding: 0 10vw">' .
                            component('Body')
                                ->is('white')
                                ->with('body', format_body($offer->data->extras)) .
                            '</div>'
                    )
                    ->pushWhen(
                        $user && $user->hasRole('superuser'),
                        component('Title')
                            ->is('center')
                            ->is('white')
                            ->with('title', 'Broneeri reis')
                    )
                    ->spacer()
            )
            ->with(
                'bottom',
                collect()->pushWhen(
                    $user && $user->hasRole('superuser'),
                    component('Form')
                        ->with('route', route('booking.create', $id))
                        ->with(
                            'fields',
                            collect()
                                ->push(
                                    component('FormTextfield')
                                        ->with('name', 'name')
                                        ->with('title', trans('offer.book.name'))
                                        ->with('value', $name)
                                )
                                ->push(
                                    component('FormTextfield')
                                        ->with('name', 'email')
                                        ->with('title', trans('offer.book.email'))
                                        ->with('value', $email)
                                )
                                ->push(
                                    component('FormTextfield')
                                        ->with('name', 'phone')
                                        ->with('title', trans('offer.book.phone'))
                                )
                                ->push(
                                    component('FormTextfield')
                                        ->with('name', 'adults')
                                        ->with('title', trans('offer.book.adults'))
                                )
                                ->push(
                                    component('FormTextfield')
                                        ->with('name', 'children')
                                        ->with('title', trans('offer.book.children'))
                                )
                                ->push(
                                    component('FormTextarea')
                                        ->with('name', 'notes')
                                        ->with('title', trans('offer.book.notes'))
                                )
                                ->push(
                                    component('FormCheckbox')
                                        ->with('name', 'insurance')
                                        ->with('title', trans('offer.book.insurance'))
                                )
                                ->push(
                                    component('FormCheckbox')
                                        ->with('name', 'installments')
                                        ->with('title', trans('offer.book.installments'))
                                )
                                ->push(
                                    component('FormCheckbox')
                                        ->with('name', 'flexible')
                                        ->with('title', trans('offer.book.flexible'))
                                )
                                ->push(
                                    component('FormButton')
                                        ->is('orange')
                                        ->is('wide')
                                        ->is('large')
                                        ->with('title', trans('offer.book.submit'))
                                )
                        )
                )
            )
            ->with('footer', region('FooterLight', ''))
            ->render();
    }
}
