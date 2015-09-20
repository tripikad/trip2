@extends('layouts.main')

@section('title')
    {{ $user->name }}
@stop

@section('navbar.bottom')
    
    @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('superuser', $user->id))
        
        <div class="utils-border-bottom">
            
            @include('component.user.menu', ['user' => $user])
        
        </div>

    @endif

@stop

@section('header.top')
    
    @include('component.user.image', [
        'image' => $user->imagePreset('small_square'),
        'options' => '-circle -large',
    ])

@stop

@section('header.bottom')
   <p>
    {{ trans('user.show.joined', [
        'created_at' => view('component.date.relative', ['date' => $user->created_at])
    ]) }}
    </p>

    @if (\Auth::check() && \Auth::user()->id !== $user->id)

        @include('component.button', [ 
            'route' => route('user.show.messages.with', [
                \Auth::user(),
                $user,
                '#message'
            ]),
            'title' => trans('user.show.message.create')
        ])

    @endif

    @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('admin', $user->id))

        @include('component.button', [ 
            'route' => route('user.edit', [$user]),
            'title' => trans('user.edit.title')
        ])

    @endif

@stop


@section('content')

    <div class="utils-border-bottom text-center">

        @include('component.user.contact')

    </div>

    <div class="utils-border-bottom">

        @include('component.user.count', [
            'content_count' => $content_count,
            'comment_count' => $comment_count
        ])

    </div>


    @if (count($user->destinationHaveBeen()) > 0 || count($user->destinationWantsToGo()) > 0)

        <div class="row utils-border-bottom">

            <div class="col-sm-6">
                
                @if (count($user->destinationHaveBeen()) > 0)
                
                    <h3>{{ trans('user.show.havebeen.title') }}</h3>

                    @include('component.user.destination', [
                        'destinations' => $user->destinationHaveBeen() 
                    ])

                @endif
        
            </div>

            <div class="col-sm-6">
            
                @if (count($user->destinationWantsToGo()) > 0)

                    <h3>{{ trans('user.show.wantstogo.title') }}</h3>

                    @include('component.user.destination', [
                        'destinations' => $user->destinationWantsToGo() 
                    ])

                @endif
        
            </div>

        </div>

    @endif
    

    <div class="utils-padding-bottom">

    @include('component.user.activity', [
        'items' => $items
    ])

    </div>

@stop
