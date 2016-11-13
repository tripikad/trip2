    <ul class="c-search-users">

    @foreach ($content as $user)

        <li class="c-search-users__item">
            <div class="c-search-users__item-image">
                @include('component.profile', [
                    'modifiers' => 'm-full m-status',
                    'image' => $user->imagePreset(),
                    'route' => ($user->name != 'Tripi külastaja' ? route('user.show', [$user]) : false),
                    'status' => [
                        'modifiers' => ['m-yellow', 'm-red', 'm-green'][rand(0,2)],
                        'position' => $user->rank,
                        'editor' => $user->role == 'admin'?true:false
                    ],
                    'letter' => [
                        'modifiers' => 'm-purple m-small',
                        'text' => $user->name[0]
                    ],
                ])
            </div>
            <h3 class="c-search-users__item-title">
                <a href="{{route('user.show', [$user])}}" class="c-search-users__item-title-link">{{ $user->name }}</a>
            </h3>
        </li>

    @endforeach

    </ul>