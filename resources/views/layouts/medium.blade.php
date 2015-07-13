@extends('layouts.main')

@section('content')

<div class="row">
    
    <div class="col-sm-1 col-lg-2">
    </div>

    <div class="col-sm-10 col-lg-8">

        @yield('content.medium')

    </div>

    <div class="col-sm-1 col-lg-2">
    </div>

</div>

@stop
