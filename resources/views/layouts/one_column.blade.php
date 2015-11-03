@extends('layouts.main')

@section('content')

@include('component.masthead',[
    'logo_modifier' => 'm-small'
])

<div class="l-one-column">

    @yield('content.one')

</div>

@stop
