    <ul class="c-search-users">

                        <li class="c-search-users__item">
                            <div class="c-search-users__item-image">
                                @include('component.profile', [
                                    'modifiers' => 'm-full m-status',
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',
                                    'status' => [
                                        'modifiers' => 'm-yellow',
                                        'position' => '2',
                                    ]
                                ])
                            </div>
                            <h3 class="c-search-users__item-title">
                                <a href="#" class="c-search-users__item-title-link">Helena Parma</a>
                            </h3>
                        </li>

                        <li class="c-search-users__item">
                            <div class="c-search-users__item-image">
                                @include('component.profile', [
                                    'modifiers' => 'm-full m-status',
                                    'route' => '#',
                                    'letter' => [
                                        'modifiers' => 'm-yellow m-small',
                                        'text' => 'K'
                                    ],
                                    'status' => [
                                        'modifiers' => 'm-yellow',
                                        'position' => '1',
                                    ]
                                ])
                            </div>
                            <h3 class="c-search-users__item-title">
                                <a href="#" class="c-search-users__item-title-link">Korval Kaup</a>
                            </h3>
                        </li>

                        <li class="c-search-users__item">
                            <div class="c-search-users__item-image">
                                @include('component.profile', [
                                    'modifiers' => 'm-full m-status',
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',

                                    'status' => [
                                        'modifiers' => 'm-red',
                                        'position' => '1',
                                    ]
                                ])
                            </div>
                            <h3 class="c-search-users__item-title">
                                <a href="#" class="c-search-users__item-title-link">Maalika Meriforell</a>
                            </h3>
                        </li>

                        <li class="c-search-users__item">
                            <div class="c-search-users__item-image">
                                @include('component.profile', [
                                    'modifiers' => 'm-full m-status',
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',

                                    'status' => [
                                        'modifiers' => 'm-purple',
                                        'position' => '3',
                                    ]
                                ])
                            </div>
                            <h3 class="c-search-users__item-title">
                                <a href="#" class="c-search-users__item-title-link">Trainer Roomassaare Juunior</a>
                            </h3>
                        </li>
                    </ul>