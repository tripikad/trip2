@component('mail::message')

# Booking for [{{ $offer->title }}]({{ $offer_route }}) {{ $offer->price }}

### {{ $offer->from }} → {{ $offer->to }}, {{ $offer->duration }}

<br>

Booking ID: **{{ $booking->id }}**

Name: **{{ $booking->name }}**

E-mail: <a href="mailto:{{ $booking->email }}">{{ $booking->email }}</a>

Phone: <a href="tel:{{ $booking->phone }}">{{ $booking->phone }}</a>

Adults: **{{ $booking->adults }}**

Children: **{{ $booking->children }}**

Needs insurance: **{{ $booking->insurance ? '✔ Yes' : 'No' }}**

Paying installments: **{{ $booking->installments ? '✔ Yes' : 'No' }}**

Flexible dates: **{{ $booking->flexible ? '✔ Yes' : 'No' }}**

<br>

**Notes:**

{{ $booking->notes }}


@endcomponent
