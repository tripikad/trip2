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
            );
    }
}
