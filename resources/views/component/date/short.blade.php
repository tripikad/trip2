{{--

description: Date.short component. Use date component to print out date or time. Date.short - d. m Y

code: |
    @include('component.date.short', ['date' => \Carbon\Carbon::now()])

--}}

<?php
if((bool)strtotime($date)===false)
    $date = date("Y-m-d H:i:s", rand( strtotime('2015-01-01 00:00:00'), strtotime(date('Y-m-d H:i:s')) ));
?>

@if(isset($date)) {{ $date->format('d. m Y') }}  @endif