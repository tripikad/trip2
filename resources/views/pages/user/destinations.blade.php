@extends('layouts.one_column')

@section('title', trans('user.destinations.title'))

@section('content.one')

    @if ($user->destinationHaveBeen()->count() > 0)

        <div id="link-have-been" class="c-user-destination">

            @include('component.row', [
                'title' => trans('user.destinations.have.been.title'),
                'text' => view('component.user.destination.destination', [
                    'destinations' => $user->destinationHaveBeen()->sortByDesc('id'),
                    'title' => trans('user.destinations.remove.title'),
                    'modifiers' => 'js-ajax_get'
                ])
            ])

        </div>

    @endif

    @if ($user->destinationWantsToGo()->count() > 0)

        <div id="link-want-to-go" class="c-user-destination">

            @include('component.row', [
                'title' => trans('user.destinations.want.to.go.title'),
                'text' => view('component.user.destination.destination', [
                    'destinations' => $user->destinationWantsToGo()->sortByDesc('id'),
                    'title' => trans('user.destinations.remove.title'),
                    'modifiers' => 'js-ajax_get'
                ])
            ])

        </div>

    @endif

    <div id="link-add-destinations" class="c-user-destination">

        {!! Form::model(null, [
            'url' => route('user.destination.store', [$user]),
            'method' => 'post'
        ]) !!}

        <div class="c-columns m-2-cols m-space">

            <div class="c-columns__item">

                <div class="c-form__group">

                    {!! Form::select(
                        'have_been[]',
                        $have_been_destinations,
                        $have_been_destination,
                        [
                            'multiple' => 'true',
                            'class' => 'js-filter',
                            'placeholder' => trans('user.destinations.have.been.title'),
                        ]
                    )!!}

                </div>

            </div>

            <div class="c-columns__item">

                <div class="c-form__group">

                    {!! Form::select(
                        'want_to_go[]',
                        $want_to_go_destinations,
                        $want_to_go_destination,
                        [
                            'multiple' => 'true',
                            'class' => 'js-filter',
                            'placeholder' => trans('user.destinations.want.to.go.title'),
                        ]
                    )!!}

                </div>

            </div>

        </div>

        <div class="c-form__input-wrap">

            <div class="c-form__group">

                {!! Form::submit(trans('user.destinations.submit.title'), [
                    'class' => 'c-button m-large m-block'
                ]) !!}

            </div>

        </div>

        {!! Form::close() !!}

    </div>

@stop
