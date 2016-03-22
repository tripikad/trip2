{{--

title: Short date

description: Date in short format

code: |
    @include('component.date.short', ['date' => \Carbon\Carbon::now()])

--}}

{{ isset($date) ? $date->format('d. m Y') : '' }}
