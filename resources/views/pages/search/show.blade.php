@extends('layouts.main')

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('masthead.search')

    @include('component.search',[
        'modifiers' => 'm-red',
        'placeholder' => trans('frontpage.index.search.title')
    ])

@stop

@section('content')

<div class="r-search">

    <div class="r-search__masthead">

        @include('component.masthead', [
            'modifiers' => 'm-search m-alternative',
            'image' => \App\Image::getHeader()
        ])
    </div>

    @if (isset($tabs) && count($tabs))
        <div class="r-search__tabs">
            <div class="r-search__tabs-wrap">
                <ul class="c-search-tabs">
                    @foreach ($tabs as $type => $tab)
                        <li class="c-search-tabs__item"><a href="{{$tab['route']}}" class="c-search-tabs__item-link {{$tab['modifier']}} js-search-tab" data-tab="{{$type}}">{{$tab['title']}} <span>{{$tab['cnt']}}</span></a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="r-search__content">

        <div class="r-search__content-wrap">

            <div class="r-search__content-container">

                <div class="c-search-container m-active js-search-container" data-container="{{$active_search}}">

                    @if($results && count($results))
                        @include('component.search.results.'.$active_search, [
                            'content' => $results
                        ])  

                        <br/>
                
                        @include('component.pagination.default', [
                            'collection' => $paginate
                        ])
                    @else
                        {{ trans('search.results.noresults') }}
                    @endif    

                </div>                       

            </div>
        </div>
    </div>

    <div class="r-search__footer-promo">

        <div class="r-search__footer-promo-wrap">

            @include('component.promo', ['promo' => 'footer'])

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