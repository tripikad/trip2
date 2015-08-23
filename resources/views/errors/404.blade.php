@extends('layouts.main')

@section('title')

	{{ trans('error.404.title') }}

@stop

@section('content')

<div class="utils-border-bottom">

{{ trans('error.404.body') }}

</div>

@stop