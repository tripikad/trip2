@extends('layouts.one_column')

@section('title')

	{{ trans('error.404.title') }}

@stop

@section('content.one')

<div class="utils-padding-bottom">
    
@include('component.card', [
    'title' => trans('error.404.body'),
    'options' => '-center -invert -noshade -wide'
])

</div>

@stop