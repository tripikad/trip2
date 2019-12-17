@component('mail::message')

# {{  trans('offer.book.email.title') }} [{{ $offer->title }}]({{ $offer_route }}) {{ $offer->price }}

{{ $offer->start_at_formatted }} → {{ $offer->end_at_formatted }}, {{ $offer->duration_formatted }}

<br>

{{ trans('offer.book.email.id') }}: {{ $booking->id }}

{{ trans('offer.book.email.hotel') }}: {{ $booking->data->hotel }}

{{ trans('offer.book.email.name') }}: {{ $booking->data->name }}

{{ trans('offer.book.email.email') }}: <a href="mailto:{{ $booking->data->email }}">{{ $booking->data->email }}</a>

{{ trans('offer.book.email.phone') }}: <a href="tel:{{ $booking->data->phone }}">{{ $booking->data->phone }}</a>

{{ trans('offer.book.email.adults') }}: {{ $booking->data->adults }}

{{ trans('offer.book.email.children') }}: {{ $booking->data->children }}

{{ trans('offer.book.email.insurance') }}: {{ $booking->data->insurance ? trans('offer.book.email.yes') : trans('offer.book.email.no') }}

{{ trans('offer.book.email.installments') }}: {{ $booking->data->installments ? trans('offer.book.email.yes') : trans('offer.book.email.no') }}

{{ trans('offer.book.email.flexible') }}: {{ $booking->data->flexible ? trans('offer.book.email.yes') : trans('offer.book.email.no') }}

<br>

@if ($booking->data->notes)

**{{ trans('offer.book.email.notes') }}:**

{{ $booking->data->notes }}

@endif

@endcomponent
