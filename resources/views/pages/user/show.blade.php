@extends('layouts.one_column')

@section('title')

    {{ $user->name }}

@stop

@section('header1.top')

    <div class="row">

        <div class="col-xs-offset-5 col-xs-2">

            @include('component.user.image', [
                'image' => $user->imagePreset('small_square'),
                'options' => '-circle -large',
            ])

        </div>

    </div>

@stop

@section('header1.bottom')
   <p>
    {{ trans('user.show.joined', [
        'created_at' => view('component.date.relative', ['date' => $user->created_at])
    ]) }}
    </p>

    @if (\Auth::check() && \Auth::user()->id !== $user->id)

        @include('component.button', [
            'route' => route('message.index.with', [
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

@section('header2.content')

    @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('superuser', $user->id))

        @include('component.nav', [
            'menu' => 'user',
            'items' => [
                'activity' => ['route' => route('user.show', [$user])],
                'message' => ['route' => route('message.index', [$user])],
                'follow' => ['route' => route('follow.index', [$user])]
            ],
            'options' => 'text-center'
        ])

    @endif

@stop

@section('content.one')

    <div class="utils-padding-bottom text-center">

        @include('component.user.contact')

    </div>

    <div class="utils-padding-bottom">

        @include('component.user.count', [
            'content_count' => $content_count,
            'comment_count' => $comment_count
        ])

    </div>


    @if (count($user->destinationHaveBeen()) > 0 || count($user->destinationWantsToGo()) > 0)

        <div class="utils-border-bottom">

                @if (count($user->destinationHaveBeen()) > 0)

                    <h3>{{ trans('user.show.havebeen.title') }}</h3>

                    @include('component.user.destination', [
                        'destinations' => $user->destinationHaveBeen()
                    ])

                @endif

        </div>

        <div class="utils-border-bottom">

                @if (count($user->destinationWantsToGo()) > 0)

                    <h3>{{ trans('user.show.wantstogo.title') }}</h3>

                    @include('component.user.destination', [
                        'destinations' => $user->destinationWantsToGo()
                    ])

                @endif

        </div>

    @endif


    <div class="utils-padding-bottom">

    @include('component.user.activity', [
        'items' => $items
    ])

    </div>

@stop
