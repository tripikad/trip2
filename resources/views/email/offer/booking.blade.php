@component('mail::message')

# {{  trans('offer.book.email.title') }} [{{ $offer->title }}]({{ $offer_route }}) {{ $offer->price }}

{{ $offer->from }} → {{ $offer->to }}, {{ $offer->duration }}

<br>

{{ trans('offer.book.email.id') }}: {{ $booking->id }}

{{ trans('offer.book.email.name') }}: {{ $booking->name }}

{{ trans('offer.book.email.email') }}: <a href="mailto:{{ $booking->email }}">{{ $booking->email }}</a>

{{ trans('offer.book.email.phone') }}: <a href="tel:{{ $booking->phone }}">{{ $booking->phone }}</a>

{{ trans('offer.book.email.adults') }}: {{ $booking->adults }}

{{ trans('offer.book.email.children') }}: {{ $booking->children }}

{{ trans('offer.book.email.insurance') }}: {{ $booking->insurance ? trans('offer.book.email.yes') : trans('offer.book.email.no') }}

{{ trans('offer.book.email.installments') }}: {{ $booking->installments ? trans('offer.book.email.yes') : trans('offer.book.email.no') }}

{{ trans('offer.book.email.flexible') }}: {{ $booking->flexible ? trans('offer.book.email.yes') : trans('offer.book.email.no') }}

<br>

@if ($booking->notes)

**{{ trans('offer.book.email.notes') }}:**

{{ $booking->notes }}

@endif

@endcomponent
