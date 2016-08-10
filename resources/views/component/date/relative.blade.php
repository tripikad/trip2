{{--

title: Relative date

description: Outputs "x days ago" etc

code: |
    @include('component.date.relative', ['date' => \Carbon\Carbon::now()])

--}}

{{ isset($date) ? $date->diffForHumans() : '' }}
