@extends('layouts.main')

@section('title')
    Login
@stop

@section('content')

@include('components.form.error')

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
