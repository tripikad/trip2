@extends('layouts.main')

@section('title')

    {{ $destination->name }}

@stop

@section('content')

<div class="row utils-border-bottom">

    <div class="col-sm-6">
    
        <h3 class="utils-padding-bottom">{{ trans('destination.index.user.havebeen.title') }}</h3>
    
        @include('component.destination.users',
            ['users' => $destination->usersHaveBeen()]
        )

    </div>

    <div class="col-sm-6">

        <h3 class="utils-padding-bottom">{{ trans('destination.index.user.wantstogo.title') }}</h3>


        @include('component.destination.users',
            ['users' => $destination->usersWantsToGo()]
        )

    </div>

</div>

@stop
