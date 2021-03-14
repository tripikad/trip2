@extends('layouts.main2')

@section('content')

    <div class="page-vp-index">

        <x-header class="page-vp-index__header" backgroundImage="{{asset('photos/pic5.jpg')}}">
            <div class="page-vp-index__header-content">
                <h3 class="page-vp-index__header-content__heading">Reisipakkumised</h3>
            </div>
        </x-header>

        <div class="container page-vp-index__content">
            <travel-offer />
        </div>

        <x-footer/>
    </div>
@endsection