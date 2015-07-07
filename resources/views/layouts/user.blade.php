@extends('layouts.main')

@section('title')
    User
@stop

@section('content')

<div class="row">
    
    <div class="col-sm-1">
    </div>

    <div class="col-sm-10">

        @yield('user')

    </div>

    <div class="col-sm-1">
    </div>

</div>

@stop
