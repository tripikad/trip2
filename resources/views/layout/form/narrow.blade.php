@extends('layout')

@section('title')
    Login
@stop

@section('content')

@include('error.messages')

<div class="row">
    
    <div class="col-sm-3">
    </div>

    <div class="col-sm-6">

        @yield('form')

    </div>

    <div class="col-sm-3">
    </div>

</div>

@stop
