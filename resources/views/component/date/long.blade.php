{{--

description: Date.long component. Use date component to print out date or time. Date.long - d. m Y H:i

code: |
    @include('component.date.long', ['date' => \Carbon\Carbon::now()])

--}}

@if((bool)strtotime($date)===false)
    {{ $date = date("Y-m-d H:i:s", rand( strtotime('2015-01-01 00:00:00'), strtotime(date('Y-m-d H:i:s')) )) }}
@endif;

@if(isset($date)) {{ $date->format('d. m Y H:i') }}  @endif