@extends('layouts.main')

@section('title')

	{{ trans('error.404.title') }}

@stop

@section('header')

@stop

@section('content')

<div class="utils-padding-bottom">
    
@include('component.card', [
    'title' => trans('error.404.title'),
    'text' => trans('error.404.body'),
    'options' => '-center -invert -noshade -wide'
])

</div>

@stop