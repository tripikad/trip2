@extends('layouts.main')

@section('header')

    @include('component.blog.header',[
        'modifiers' => 'm-alternative',
        'back' => [
            'title' => 'trip.ee blogid',
            'route' => '/content/blog'
        ],
        'logo' => true
    ])
@stop

@section('content')

<div class="r-blog m-edit">

    <div class="r-blog__masthead">

        @include('component.blog.masthead')
    </div>

    <div class="r-blog__wrap">

        <div class="r-blog__wrap-inner m-smaller">

            <div class="r-blog__content m-small">

                <div class="r-block m-small">

                    <div class="r-block__header">

                        @include('component.title', [
                            'modifiers' => 'm-largest m-blue',
                            'title' => 'Uus postitus'
                        ])
                    </div>

                    <div class="r-block__inner">

                        <div class="r-block__header">

                            @include('component.title', [
                                'modifiers' => 'm-red m-large',
                                'title' => 'Hea teada'
                            ])
                        </div>

                        <div class="r-block__body">

                            <div class="c-body">

                                <p>Austan eesti keele reegleid, jälgin et minu kirjutised oleks loetavad, ma ei kasuta slängi, suurtähti ja korduvaid kirjavahemärke ning kasutan suuri algustähti lause alguses ja kohanimedes.</p>
                                <p>Tean ja nõustun, et kasutustingimuste rikkumisel võidakse minu kasutuskonto ilma hoiatamata sulgeda ja/või minu ligipääs Trip.ee'le blokeerida.</p>

                                @include('component.link', [
                                    'modifiers' => 'm-icon',
                                    'title' => 'Loe lähemalt',
                                    'route' => '#',
                                    'icon' => 'icon-arrow-right'
                                ])
                            </div>
                        </div>
                    </div>
                </div>

                <div class="c-form__group">
                    {!! Form::label('blog-post-title', 'Pealkiri', [
                        'class' => 'c-form__label'
                    ]) !!}
                    <div class="c-form__input-wrap">
                        {!! Form::text('blog-post-title', null, [
                            'class' => 'c-form__input',
                        ]) !!}
                    </div>
                </div>

                <div class="c-form__group">
                    {!! Form::label('blog-post-body', 'Sisu', [
                        'class' => 'c-form__label'
                    ]) !!}
                    <div class="c-form__input-wrap">
                        {!! Form::textarea('blog-post-body', null, [
                            'class' => 'c-form__input m-high js-ckeditor',
                            'placeholder' => '',
                        ]) !!}
                    </div>
                </div>

                <div class="c-form__group">
                    {!! Form::label('blog-post-bg-image', 'Lisa taustapilt', [
                        'class' => 'c-form__label'
                    ]) !!}
                    <p class="c-form__note m-small-margin">Kuvatakse antud blogiposti päise taustana</p>

                    <div class="c-columns m-2-cols m-last-smaller m-space">

                        <div class="c-columns__item">

                            <div class="c-form__input-wrap">

                                @include('component.image.form', [
                                   'form' => [
                                       'url' => '/content/blog/edit',
                                       'files' => true
                                   ],
                                   'name' => 'blog-post-bg-image',
                                   'maxFileSize' => 5,
                                   'uploadMultiple' => false
                               ])
                           </div>
                        </div>

                        <div class="c-columns__item">

                            @include('component.svg.standalone', [
                                'name' => ''
                            ])
                        </div>
                    </div>
                </div>

                <div class="c-form__group">
                    {!! Form::label('blog-post-gallery-images', 'Lisa galerii', [
                        'class' => 'c-form__label'
                    ]) !!}
                    <div class="c-form__input-wrap">
                        @include('component.image.form', [
                           'form' => [
                               'url' => '/content/blog/edit',
                               'files' => true
                           ],
                           'name' => 'blog-post-gallery-images',
                           'maxFileSize' => 5,
                           'uploadMultiple' => true
                       ])
                   </div>
                </div>

                <div class="c-form__group m-large-margin">
                    {!! Form::label('blog-post-tags', 'Tag\'id', [
                        'class' => 'c-form__label'
                    ]) !!}
                    <div class="c-form__group-select">
                        {!! Form::select('blog-post-tags', ['Reisivarustus', 'Lennupiletid', 'Muu'], null, [
                            'class' => 'c-select js-filter',
                            'id' => 'blog-post-tags',
                            'placeholder' => 'Vali',
                            'multiple' => 'true',
                        ]) !!}
                    </div>
                </div>

                <div class="c-form__note">Enne pakkumise sisestamist kontrolli palun uuesti kõik sisestatud andmed</div>

                <div class="c-form__group m-small-margin">
                    <a href="#" class="c-button m-tertiary m-large m-block">Vaata eelvaadet</a>
                </div>

                {!! Form::submit('Avalda', [
                    'class' => 'c-button m-large m-block'
                ]) !!}
            </div>
        </div>
    </div>

    <div class="r-blog__footer-promo">

        <div class="r-blog__wrap">

            @include('component.promo', [
                'modifiers' => 'm-footer',
                'route' => '',
                'image' => \App\Image::getRandom()
            ])
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