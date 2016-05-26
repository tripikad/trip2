<div class="c-travelmate-user {{ $modifiers or 'm-yellow' }}">

    <div class="c-travelmate-user__header">

        <div class="c-travelmate-user__image">
            @if(isset($user_route))
            <a href="{{ $user_route }}" class="c-travelmate-user__image-link">
            @endif

                @if (isset($image))

                    @if ($image != '')

                        <img src="{{ $image }}" alt="">

                    @else

                        @if (isset($letter))

                            <div class="c-travelmate-user__letter {{ $letter['modifiers'] }}"><span>{{ $letter['text'] }}</span></div>

                        @endif

                    @endif

                @else

                    @if (isset($letter))

                        <div class="c-travelmate-user__letter {{ $letter['modifiers'] }}"><span>{{ $letter['text'] }}</span></div>

                    @endif

                @endif

            @if(isset($user_route))
            </a>
            @endif
        </div>

        <div class="c-travelmate-user__header-info">

            <h2 class="c-travelmate-user__title">
                @if(isset($user_route))
                <a href="{{ $user_route }}" class="c-travelmate-user__title-link">
                @endif

                    {{ str_limit($name, 18) }}
                    @if(isset($sex_and_age) && $sex_and_age != '')
                        <span></span>
                    @endif
                @if(isset($user_route))
                </a>
                @endif
            </h2>

            @if(isset($social_items))

            <div class="c-travelmate-user__social">

                <ul class="c-button-group">

                    @foreach($social_items as $social)

                        @if (isset($social['route']) && $social['route']!='')

                            <li class="c-button-group__item">
                                @include('component.button',[
                                    'modifiers' => 'm-icon m-small m-round',
                                    'icon' => view('component.svg.sprite',['name' => $social['icon']]),
                                    'route' => $social['route'],
                                    'target' => '_blank'
                                ])
                            </li>

                        @endif

                    @endforeach
                </ul>

            </div>

            @endif

        </div>
    </div>

    @if (isset($description) && $description != '')

        <div class="c-travelmate-user__body">
            <div class="c-body">
                {!! $description !!}
            </div>
        </div>

    @endif

    @if (\Auth::user())
        @if(\Auth::user()->id !== $user->id)

            <div class="c-travelmate-user__footer">
                @include('component.button', [
                    'modifiers' => 'm-block m-secondary',
                    'title' => trans('content.action.message.send'),
                    'route' => route('message.index.with', [
                        \Auth::user(),
                        $user,
                        '#message'
                    ])
                ])
            </div>

        @endif
    @endif

</div>
