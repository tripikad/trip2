@extends('layouts.main')

@section('content')

@include('component.masthead')

<div class="l-one-column">

    @parent

    @yield('content.one')

</div>

@stop
