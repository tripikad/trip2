@extends('layout')

@section('content')

<div style="margin-top: -40px;">

@foreach($fronts as $type => $front) 

    <div class="row" style="margin: 30px 0 10px 0;">
        
        <div class="col-md-5">
        </div>
        
        <div class="col-md-2">
            @include('component.placeholder', ['text' => $front['title']])
        </div>
        
        <div class="col-md-5">
        </div>
    
    </div>

    @include("content.$type.front", [
        'title' => $front['title'],
        'contents' => $front['contents']
    ])

@endforeach

</div>

@stop
