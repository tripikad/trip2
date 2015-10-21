{{--

description: Date.long component. Use date component to print out date or time. Date.long - d. m Y H:i

code: |
    @include('component.date.long', ['date' => \Carbon\Carbon::now()]);

--}}

@if(isset($date)) {{ $date->format('d. m Y H:i') }}  @endif