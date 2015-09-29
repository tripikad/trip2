@extends('layouts.main')

@section('title')

    {{ $destination->name }}

@stop

@section('header1.image')

    @if(isset($features['photo']['contents'][0]))

        {{ $features['photo']['contents'][0]->imagePreset('large') }}

    @endif

@stop

@section('content')

<div class="utils-border-bottom">

    @foreach($features as $type => $feature) 

        @include("component.content.$type.frontpage", [
            'contents' => $feature['contents']
        ])
        
    @endforeach

</div>

<div class="utils-border-bottom">
        
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

@stop
