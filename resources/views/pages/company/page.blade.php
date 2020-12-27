@extends('layouts.main2')

@section('content')

    <div class="page-company-page">
        <x-header>
            <div class="page-company-page__header-content">
                <h3 class="page-company-page__header-content__heading">{{$company->name}}</h3>
                <x-tabs :tabs="$items"/>
            </div>
        </x-header>

        <div class="container page-company-page__content">
            <div class="row">
                <div class="col-md-8 col-12">
                    {!! nl2br($user->description) !!}
                </div>
                <div class="col-md-4 col-12 mt-5 mt-md-0">
                    <div class="page-company-page__info">
                        <table>
                            <tr>
                                <th>Asukoht</th>
                                <td><a href="#">{{$company->name}}</a></td>
                            </tr>
                            <tr>
                                <th>Koduleht</th>
                                <td><a href="{{$user->contact_homepage}}">{{$user->contact_homepage}}</a></td>
                            </tr>
                        </table>
                    </div>
                    <div class="page-company-page__image">
                        <img src="https://www.worldwideinsure.com/travel-blog/wp-content/uploads/2017/12/Hotel-Room-Image-by-Megha01-CC0.jpg" class=""/>
                        <span class="page-company-page__image__gallery">Galerii</span>
                    </div>
                </div>
            </div>
        </div>

        <x-footer/>
    </div>
@endsection
