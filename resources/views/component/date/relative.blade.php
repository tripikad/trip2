{{--

description: Date.relative component.  Use date component to print out date or time. For example, date.relative prints out X days ago, X seconds ago, X months ago etc.

code: |
    @include('component.date.relative', ['date' => \Carbon\Carbon::now()])

--}}

<?php
if((bool)strtotime($date)===false)
    $date = date("Y-m-d H:i:s", rand( strtotime('2015-01-01 00:00:00'), strtotime(date('Y-m-d H:i:s')) ));
?>

@if(isset($date)) {{ Date::parse($date)->diffForHumans() }} @endif