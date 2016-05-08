@extends('layouts.main')
@section('content')
    @include('component.masthead')
    <div class="l-one-column">
        @yield('content.one')
    </div>
@stop
