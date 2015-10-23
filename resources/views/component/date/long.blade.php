{{--

title: Long date

description: Date and time in long format

code: |
    @include('component.date.long', ['date' => \Carbon\Carbon::now()])

--}}

<?php
if((bool)strtotime($date)===false)
    $date = date("Y-m-d H:i:s", rand( strtotime('2015-01-01 00:00:00'), strtotime(date('Y-m-d H:i:s')) ));
?>

@if(isset($date)) {{ $date->format('d. m Y H:i') }}  @endif