@extends('layouts.main')

@section('title', trans("content.$type.index.title"))

@section('header')

    @include('component.blog.header',[
        'modifiers' => 'm-show',
        'back' => [
            'title' => 'trip.ee blogid',
            'route' => '/content/blog'
        ],
    ])
@stop

@section('content')

<div class="r-blog m-show">

    <div class="r-blog__masthead">

        @include('component.blog.masthead', [
            'modifiers' => 'm-show',
            'image' => \App\Image::getRandom(),
            'title' => $content->title,
            'date' => '10. jaanuar 2016',
            'user' => [
                'route' => '#',
                'name' => 'Charles Blunt',
                'color' => 'm-green',
                'letter' => 'J',
                'status' => '1',
                'image' => \App\Image::getRandom(),
                'editor' => true
            ]
        ])
    </div>

    <div class="r-blog__content">

{{-- VANA BLOGI --}}
        @include('component.row', [
            'modifiers' => 'm-image',
            'profile' => [
                'modifiers' => '',
                'image' => $content->user->imagePreset(),
                'route' => ($content->user->name != 'Tripi külastaja' ? route('user.show', [$content->user]) : false)
            ],
            'title' => $content->title,
            'text' => view('component.content.text', ['content' => $content]),
            'actions' => view('component.actions', ['actions' => $content->getActions()]),
            'extra' => view('component.flags', ['flags' => $content->getFlags()]),
            'body' => $content->body_filtered,
        ])
{{-- VANA BLOGI --}}

        <div class="c-blog-single">

            <div class="r-blog__wrap">

                <div class="r-blog__wrap-inner m-small">

                    <div class="c-blog-single__body">

                        {!! $content->body_filtered !!}

                        <?php /*UUS BLOGI
                        <div class="c-blog-single__iframe">

                            <iframe src="https://player.vimeo.com/video/153737805" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        </div>

                        <p>My fiance and I were out at a bar the other night after a movie and we witnessed a probably very common occurrence. I was sitting on a stool with my back to the bar and he was standing in front of me. Next to me was a dressed up, dark haired young girl sitting next to her friend. Talking to her was a guy at least eight to ten years older than her. He tried to pretend like he knew us like we would provide some social proof for him. He was buying them drinks and working very hard to get her out of the bar.</p>

                        <img src="{{ \App\Image::getRandom() }}" alt="" class="m-right">

                        <p>I was a little mama bearish and talked to her a bit. She explained that she was 21, home from college and that she had a curfew so she would have to go soon. It seemed like the girls were exiting with him and his friends but I wasn’t paying too much attention. I gave her a quick “be careful” as she left.</p>

                        <p>A little while later Kellen nudges me and says “I guess they are breaking curfew” and points to the two girls back at the bar. We were about to walk out so we stopped over and joked about curfew. The dark haired girl said “Oh no we left saying we had a curfew to trick those guys into leaving us alone.” Ugh. “Trick those guys into leaving us alone.” In our brief chat it didn’t even dawn on them that they could say “No thank you” or “Hey, it’s been nice chatting with you but I am going to get back to hanging out with my friend now” or any other version of “Thank you but I am not interested”.</p>

                        <ul>
                            <li>“I guess they are breaking curfew”</li>
                            <li>“Wow. I didn’t even think of that.” </li>
                            <li>“Trick those guys into leaving us alone.”</li>
                        </ul>

                        <p>So I suggested it and they were literally like “Wow. I didn’t even think of that.” It made me a little sad. These were smart young women that go to good schools and somehow it had not been communicated to them at any point that they could set boundaries with men. We talked about the commerce of the guys buying them drinks and that if they didn’t want to feel like they owed the guys anything not to let them buy. We also talked about the fact that even though the guys bought them drinks they didn’t owe them anything anyway. And as I left I emphasized how it is always ok to say “No thank you.”</p> */ ?>
                    </div>
                </div>
            </div>

            <div class="r-blog__wrap">

                <div class="r-blog__wrap-inner">

                    <div class="c-blog-single__gallery">

                        <div class="c-blog-single__gallery-header">

                            @include('component.title', [
                                'modifiers' => 'm-green',
                                'title' => 'Galerii'
                            ])
                        </div>

                        @include('component.gallery', [
                            'columns' => 6,
                            'modal' => [
                                'modifiers' => 'm-green',
                            ],
                            'items' => [
                                [
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',
                                    'alt' => 'Pilt 1'
                                ],
                                [
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',
                                    'alt' => 'Pilt 2'
                                ],
                                [
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',
                                    'alt' => 'Pilt 3'
                                ],
                                [
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',
                                    'alt' => 'Pilt 4'
                                ],
                                [
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',
                                    'alt' => 'Pilt 5'
                                ],
                                [
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',
                                    'alt' => 'Pilt 6'
                                ],
                            ]
                        ])
                    </div>
                </div>
            </div>

            <div class="r-blog__wrap">

                <div class="r-blog__wrap-inner m-small">

                    <div class="c-blog-single__meta">

                        <div class="c-blog-single__tags">

                            @include('component.blog.tags', [
                                'items' => [
                                    [
                                        'title' => 'Aafrika',
                                        'route' => '#'
                                    ],
                                    [
                                        'title' => 'Põhja-Ameerika',
                                        'route' => '#'
                                    ]
                                ]
                            ])
                        </div>

                        <div class="c-blog-single__flags">

                            @include('component.flags', [
                                'flags' => $content->getFlags()
                            ])
                        </div>

                        <div class="c-blog-single__social">
                            @include('component.blog.social')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="r-blog__comments">
        <div class="r-blog__wrap">
            <div class="r-blog__wrap-inner m-smaller">

                @if (count($content->comments) > 0)

                <div class="r-block m-small">

                    <div class="r-block__header">

                        @include('component.title', [
                            'modifiers' => 'm-green',
                            'title' => 'Kommentaarid'
                        ])
                    </div>

                    @include('component.comment.index', ['comments' => $content->comments])

                    <?php /*UUS KOMMENTAARI DISAIN
                     #include('component.content.forum.post', [
                        'profile' => [
                            'modifiers' => 'm-full m-status',
                            'image' => \App\Image::getRandom(),
                            'title' => 'Charles Blunt',
                            'route' => '#',
                            'letter' => [
                                'modifiers' => 'm-yellow m-small',
                                'text' => 'J'
                            ],
                            'status' => [
                                'modifiers' => 'm-yellow',
                                'position' => '3',
                            ]
                        ],
                        'date' => '10. jaanuar, 17:11',
                        'text' => '<p>Mina puurisin nüüd juba mitu-mitu aastat tagasi oma Kagu-Aasia reiside eel samuti mitme (Eesti) kindlustusfirma tingimusi. Muidu olid välistused jne suhteliselt ühtsed, kui välja arvata mõned nüansid.</p><p>Kuna mul oli plaanis arengumaades maapiirkondades kohalikke (arvatavasti) igasuguse litsentsita reisijuhte kasutada, näiteks kuskilt väikesest kohast ümberkaudsete külade üleöö külastamiseks ehk pikad jalgsimatkad mägistes piirkondades, oli tarvis, et juhul kui juhtub õnnetus, see ka korvatakse. Tegemist ei olnud siis spordiga, vaid lihtsalt keskmisest veidi koormavamate matkadega. Kokkuvõttes oli sel ajal vaid Ifil kindlustuses selline asi sees, sai ka kirjalikult üle küsitud (et oleks tõestusmaterjal hiljem!) ning teised firmad pakkusid seda lisakaitse all päris räiga lisahinnaga või ei võtnud üldse jutule, kui giidi litsentsi poleks ette näidata.</p>',
                        'thumbs' => view('component.flags', ['flags' => $content->getFlags()]),
                    ])

                     #include('component.content.forum.post', [
                        'profile' => [
                            'modifiers' => 'm-full m-status',
                            'image' => \App\Image::getRandom(),
                            'title' => 'Charles Blunt',
                            'route' => '#',
                            'letter' => [
                                'modifiers' => 'm-yellow m-small',
                                'text' => 'J'
                            ],
                            'status' => [
                                'modifiers' => 'm-yellow',
                                'position' => '3',
                            ]
                        ],
                        'date' => '10. jaanuar, 17:11',
                        'text' => '<p>Mina puurisin nüüd juba mitu-mitu aastat tagasi oma Kagu-Aasia reiside eel samuti mitme (Eesti) kindlustusfirma tingimusi. Muidu olid välistused jne suhteliselt ühtsed, kui välja arvata mõned nüansid.</p><p>Kuna mul oli plaanis arengumaades maapiirkondades kohalikke (arvatavasti) igasuguse litsentsita reisijuhte kasutada, näiteks kuskilt väikesest kohast ümberkaudsete külade üleöö külastamiseks ehk pikad jalgsimatkad mägistes piirkondades, oli tarvis, et juhul kui juhtub õnnetus, see ka korvatakse. Tegemist ei olnud siis spordiga, vaid lihtsalt keskmisest veidi koormavamate matkadega. Kokkuvõttes oli sel ajal vaid Ifil kindlustuses selline asi sees, sai ka kirjalikult üle küsitud (et oleks tõestusmaterjal hiljem!) ning teised firmad pakkusid seda lisakaitse all päris räiga lisahinnaga või ei võtnud üldse jutule, kui giidi litsentsi poleks ette näidata.</p>',
                        'thumbs' => view('component.flags', ['flags' => $content->getFlags()]),
                    ])
                    */ ?>
                </div>

                @endif

                @if (\Auth::check())

                    <div class="r-block m-small m-no-margin">

                        <div class="r-block__header">

                            @include('component.title', [
                                'modifiers' => 'm-green m-large',
                                'title' => 'Lisa kommentaar'
                            ])

                        </div>

                        @include('component.comment.create')
                    </div>

                @endif
            </div>
        </div>
    </div>

    <div class="r-blog__offers">

        <div class="r-blog__wrap">

            <div class="c-columns m-3-cols">

                <div class="c-columns__item">

                    @include('component.card', [
                        'route' => '#',
                        'title' => 'Edasi-tagasi Riiast või Helsingist Bangkoki al. 350 €',
                        'image' => \App\Image::getRandom()
                    ])

                </div>

                <div class="c-columns__item">

                    @include('component.card', [
                        'route' => '#',
                        'title' => 'Air China Stockholmist Filipiinidele, Singapuri või Hongkongi al. 285 €',
                        'image' => \App\Image::getRandom()
                    ])

                </div>

                <div class="c-columns__item">

                    @include('component.card', [
                        'route' => '#',
                        'title' => 'Riiast Maltale al. 350 €',
                        'image' => \App\Image::getRandom()
                    ])

                </div>
            </div>
        </div>
    </div>

    <div class="r-blog__footer-promo">

        <div class="r-blog__wrap">

            @include('component.promo', ['promo' => 'footer'])

        </div>
    </div>
</div>

@stop

@section('footer')

    @include('component.footer', [
        'modifiers' => 'm-alternative',
        'image' => \App\Image::getRandom()
    ])

@stop
