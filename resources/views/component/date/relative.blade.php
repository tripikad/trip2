{{--

description: Date.relative component.  Use date component to print out date or time. For example, date.relative prints out X days ago, X seconds ago, X months ago etc.

code: |
    @include('component.date.relative', ['date' => \Carbon\Carbon::now()]);

--}}

@if(isset($date)) {{ Date::parse($date)->diffForHumans() }} @endif