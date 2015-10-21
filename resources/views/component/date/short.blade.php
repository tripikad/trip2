{{--

description: Date.short component. Use date component to print out date or time. Date.short - d. m Y

code: |
    @include('component.date.short', ['date' => \Carbon\Carbon::now()]);

--}}

@if(isset($date)) {{ $date->format('d. m Y') }}  @endif