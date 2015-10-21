{{--

description: date.relative

code: |
    @include('component.date.relative', ['date' => \Carbon\Carbon::now()]);

--}}

@if(isset($date)) {{ Date::parse($date)->diffForHumans() }} @endif