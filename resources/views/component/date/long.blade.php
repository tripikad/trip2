{{--

title: Long date

description: Date and time in long format

code: |
    @include('component.date.long', ['date' => \Carbon\Carbon::now()])

--}}

{{ isset($date) ? $date->format('d. m Y H:i') : '' }}
