@extends('layouts.main')

@section('content')

@foreach($fronts as $type => $front) 

    @include("components.content.$type.front", [
        'contents' => $front['contents']
    ])
    
    <hr style="margin-top: 5px;" />
    
@endforeach

</div>

@stop
