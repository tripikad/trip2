@extends('layouts.main')

@section('title')
    {{ trans($content->title) }}
@stop

@section('content')

    <div class="utils-border-bottom 
        @if (! $content->status)
            utils-unpublished
        @endif
    ">

        <div class="row">

            <div class="col-sm-1">
            </div>

            <div class="col-sm-10">

                {!! nl2br($content->body) !!}

            </div>
            
            
        </div>

    </div>
    

@stop