<?php

namespace App\Http\Regions;

class OfferBooking
{
    public function render($id, $name, $email)
    {
        return component('Form')
            ->withRoute(route('booking.create', $id))
            ->withFields(
                collect()
                    ->push(
                        component('FormTextfield')
                            ->withName('name')
                            ->withTitle(trans('offer.book.name'))
                            ->withDescription(trans('site.required'))
                            ->withValue($name)
                    )
                    ->push(
                        component('FormTextfield')
                            ->withName('email')
                            ->withTitle(trans('offer.book.email'))
                            ->withDescription(trans('site.required'))
                            ->withValue($email)
                    )
                    ->push(
                        component('FormTextfield')
                            ->withName('phone')
                            ->withTitle(trans('offer.book.phone'))
                            ->withDescription(trans('site.required'))
                    )
                    ->push(
                        component('FormTextfield')
                            ->withName('adults')
                            ->withTitle(trans('offer.book.adults'))
                    )
                    ->push(
                        component('FormTextfield')
                            ->withName('children')
                            ->withTitle(trans('offer.book.children'))
                    )
                    ->push(
                        component('FormTextarea')
                            ->withName('notes')
                            ->withTitle(trans('offer.book.notes'))
                    )
                    ->push(
                        component('FormCheckbox')
                            ->withName('insurance')
                            ->withTitle(trans('offer.book.insurance'))
                    )
                    ->push(
                        component('FormCheckbox')
                            ->withName('installments')
                            ->withTitle(trans('offer.book.installments'))
                    )
                    ->push(
                        component('FormCheckbox')
                            ->withName('flexible')
                            ->withTitle(trans('offer.book.flexible'))
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
