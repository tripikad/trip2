@extends('layouts.main')

@section('title')

    {{ $destination->name }}

@stop

@section('header')

<div class="utils-border-bottom">

    @include('component.card', [
        'title' => $destination->name,
        'options' => '-center -wide -large',
        'image' => $image,
    ])

</div>

@stop

@section('content')


<div class="row utils-border-bottom">

    <div class="col-sm-5">
        
        @if(count($destination->usersHaveBeen()) > 0)

            <h3 class="utils-padding-bottom">{{ trans('destination.index.user.havebeen.title') }}</h3>
    
            @include('component.destination.users',
                ['users' => $destination->usersHaveBeen()]
            )

        @endif

    </div>

    <div class="col-sm-5 col-sm-offset-1">

        @if(count($destination->usersWantsToGo()) > 0)

            <h3 class="utils-padding-bottom">{{ trans('destination.index.user.wantstogo.title') }}</h3>

            @include('component.destination.users',
                ['users' => $destination->usersWantsToGo()]
            )

        @endif

    </div>

</div>

@stop
