{{--

title: Short date

description: Date in short format

code: |
    @include('component.date.short', ['date' => \Carbon\Carbon::now()])

--}}

<?php
if((bool)strtotime($date)===false)
    $date = date("Y-m-d H:i:s", rand( strtotime('2015-01-01 00:00:00'), strtotime(date('Y-m-d H:i:s')) ));
?>

@if(isset($date)) {{ $date->format('d. m Y') }}  @endif