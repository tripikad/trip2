<?php

namespace App\Http\Regions;

class OfferBooking
{
    public function render($id, $name, $email, $offer)
    {
        return component('FormComponent')
            ->withRoute(route('booking.create', $id))
            ->withFields(
                collect()
                    ->push(component('FormCaptcha'))
                    ->push(
                        component('Title')
                            ->is('small')
                            ->is('blue')
                            ->with('title', trans('offer.book.hotel'))
                    )
                    ->push(region('OfferBookingHotel', $offer))
                    ->push(
                        component('Title')
                            ->is('small')
                            ->is('blue')
                            ->with('title', trans('offer.book.contact'))
                    )
                    ->push(
                        component('FormTextfield')
                            ->withName('name')
                            ->withTitle(trans('offer.book.name'))
                            ->withDescription(trans('site.suggested'))
                            ->withValue(old('name'))
                    )
                    ->push(
                        component('FormTextfield')
                            ->withName('email')
                            ->withTitle(trans('offer.book.email'))
                            ->withDescription(trans('site.required'))
                            ->withValue($email)
                            ->withValue(old('email'))
                    )
                    ->push(
                        component('FormTextfield')
                            ->withName('phone')
                            ->withTitle(trans('offer.book.phone'))
                            ->withDescription(trans('site.required'))
                            ->withValue(old('phone'))
                    )
                    ->push(
                        component('FormTextfield')
                            ->withName('adults')
                            ->withTitle(trans('offer.book.adults'))
                            ->withValue(old('adults'))
                    )
                    ->push(
                        component('FormTextfield')
                            ->withName('children')
                            ->withTitle(trans('offer.book.children'))
                            ->withValue(old('children'))
                    )
                    ->push(
                        component('FormTextarea')
                            ->withName('notes')
                            ->withTitle(trans('offer.book.notes'))
                            ->withValue(old('notes'))
                    )
                    ->push(
                        component('FormCheckbox')
                            ->withName('insurance')
                            ->withTitle(trans('offer.book.insurance'))
                            ->withValue(old('insurance'))
                    )
                    ->push(
                        component('FormCheckbox')
                            ->withName('installments')
                            ->withTitle(trans('offer.book.installments'))
                            ->withValue(old('installments'))
                    )
                    ->push(
                        component('FormCheckbox')
                            ->withName('flexible')
                            ->withTitle(trans('offer.book.flexible'))
                            ->withValue(old('flexible'))
                    )
                    ->push(
                        component('FormButton')
                            ->is('orange')
                            ->is('wide')
                            ->is('large')
                            ->withTitle(trans('offer.book.submit'))
                    )
            );
    }
}
