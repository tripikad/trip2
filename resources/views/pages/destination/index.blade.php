@extends('layouts.main')

@section('title')

    {{ $destination->name }}

@stop


@section('content')

<div class="utils-border-bottom">

    @foreach($features as $type => $feature) 

        @include("component.content.$type.frontpage", [
            'contents' => $feature['contents']
        ])
        
    @endforeach

</div>

<div class="row utils-border-bottom">

    <div class="col-sm-5">
        
        @if(count($destination->usersHaveBeen()) > 0)

            <h3 class="utils-padding-bottom">
            
                {{ trans('destination.index.user.havebeen.title', [
                    'count' => count($destination->usersHaveBeen())
                ]) }}
            
            </h3>
    
            @include('component.destination.users',
                ['users' => $destination->usersHaveBeen()]
            )

        @endif

    </div>

    <div class="col-sm-5 col-sm-offset-1">

        @if(count($destination->usersWantsToGo()) > 0)

        <h3 class="utils-padding-bottom">
        
            {{ trans('destination.index.user.wantstogo.title', [
                'count' => count($destination->usersWantsToGo())
            ]) }}
        
        </h3>
            @include('component.destination.users',
                ['users' => $destination->usersWantsToGo()]
            )

        @endif

    </div>

</div>

@stop
