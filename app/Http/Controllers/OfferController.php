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
        $offer = Offer::public()->findOrFail($id);

        $photos = Content::getLatestPagedItems('photo', 9, $offer->endDestinations->first()->id);

        $user = auth()->user();
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
                    ->push(
                        component('Flex')
                            ->with('justify', 'center')
                            ->with(
                                'items',
                                collect()
                                    ->push(
                                        component('Title')
                                            ->is('small')
                                            ->is('center')
                                            ->is('white')
                                            ->with('title', $offer->duration_formatted)
                                    )
                                    ->push(
                                        component('Title')
                                            ->is('small')
                                            ->is('center')
                                            ->is('white')
                                            ->is('semitransparent')
                                            ->with(
                                                'title',
                                                $offer->start_at_formatted . ' → ' . $offer->end_at_formatted
                                            )
                                    )
                            )
                    )
                    ->br()
                    ->push(
                        component('Flex')
                            ->with('justify', 'center')
                            ->with('gap', 'sm')
                            ->with(
                                'items',
                                collect()
                                    ->push(
                                        component('Title')
                                            ->is('smallest')
                                            ->is('white')
                                            ->is('semitransparent')
                                            ->with('title', 'Firma')
                                    )
                                    ->push(
                                        component('Title')
                                            ->is('smallest')
                                            ->is('white')
                                            ->with('title', $offer->user->name)
                                    )
                                    ->pushWhen(
                                        $offer->data->guide !== '',
                                        component('Title')
                                            ->is('smallest')
                                            ->is('white')
                                            ->is('semitransparent')
                                            ->with('title', 'Giid')
                                    )
                                    ->pushWhen(
                                        $offer->data->guide !== '',
                                        component('Title')
                                            ->is('smallest')
                                            ->is('white')
                                            ->with('title', $offer->data->guide)
                                    )
                                    ->pushWhen(
                                        $offer->data->size !== '',
                                        component('Title')
                                            ->is('smallest')
                                            ->is('white')
                                            ->is('semitransparent')
                                            ->with('title', 'Grupi suurus')
                                    )
                                    ->pushWhen(
                                        $offer->data->size !== '',
                                        component('Title')
                                            ->is('smallest')
                                            ->is('white')
                                            ->with('title', $offer->data->size)
                                    )
                            )
                    )
                    ->br()
                    ->pushWhen(
                        $photos->count(),
                        region('PhotoRow', $photos->count() < 18 ? $photos->slice(0, 9) : $photos)
                    )
                    ->br()
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
                    ->br()
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
