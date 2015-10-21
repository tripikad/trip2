{{--

description: date.short

code: |
    @include('component.date.short', ['date' => \Carbon\Carbon::now()]);

--}}

@if(isset($date)) {{ $date->format('d. m Y') }}  @endif