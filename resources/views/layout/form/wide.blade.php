@extends('layout')

@section('title')
    Login
@stop

@section('content')

@include('error.messages')

<div class="row">
    
    <div class="col-sm-1">
    </div>

    <div class="col-sm-10">

        @yield('form')

    </div>

    <div class="col-sm-1">
    </div>

</div>

@stop
