{{--

description: date.long

code: |
    @include('component.date.long', ['date' => \Carbon\Carbon::now()]);

--}}

@if(isset($date)) {{ $date->format('d. m Y H:i') }}  @endif