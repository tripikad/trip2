@extends('layouts.main')

@section('title', $content->title)

@section('header')
    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])
@stop

@section('head_image', $content->getHeadImage())

@section('content')

    <div class="r-general m-col-1">
        <div class="r-general__masthead">
            @include('component.masthead', [
                'modifiers' => 'm-alternative m-small',
                'image' => $content->imagePreset('large'),
                'actions' => view('component.actions', ['actions' => $content->getActions()]),
            ])
        </div>

        <div class="r-general__content-wrap m-large-offset-bottom">
            <div class="r-general__content">
                <div class="r-medium-wrapper__center">
                    <div class="r-container">
                        @include('component.row', [
                            'text' => view('component.content.text', ['content' => $content]),
                            'extra' => view('component.flags', ['flags' => $content->getFlags()]),
                            'body' => [
                                'modifiers' => 'm-large-offset-top  m-large-offset-bottom',
                                'text' => $content->body_filtered,
                            ]
                        ])

                        @if (isset($comments) && count($comments))
                            <div class="r-block">
                                <div class="r-block__header">
                                    <div class="r-block__header-title">
                                        @include('component.title', [
                                            'title' => trans('content.comments.title'),
                                            'modifiers' => 'm-green'
                                        ])
                                    </div>
                                </div>

                                <div class="r-block__body">
                                    @include('component.comment.index', ['comments' => $comments])
                                </div>
                            </div>
                        @endif

                        @if (\Auth::check())
                            <div class="r-block">
                                <div class="r-block__inner">
                                    <div class="r-block__header">
                                        <div class="r-block__header-title">
                                            @include('component.title', [
                                                'title' => trans('content.action.add.comment'),
                                                'modifiers' => 'm-large m-green'
                                            ])
                                        </div>
                                    </div>

                                    <div class="r-block__body">
                                        @include('component.comment.create')
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    @include('component.footer', [
        'modifiers' => 'm-alternative',
        'image' => \App\Image::getFooter()
    ])
@stop
