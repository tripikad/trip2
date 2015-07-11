@extends('layouts.main')

@section('title')
    Login
@stop

@section('content')

@include('components.form.error')

<div class="row">
    
    <div class="col-sm-1 col-lg-2">
    </div>

    <div class="col-sm-10 col-lg-8">

        @yield('form')

    </div>

    <div class="col-sm-1 col-lg-2">
    </div>

</div>

@stop
