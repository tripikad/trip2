@extends('layouts.main2')

@section('content')

    <div class="page-company-page">
        <div class="page-company-page__header">
            <div class="container">
                <div class="page-company-page__navigation">
                    <x-navbar/>
                </div>

                <div class="page-company-page__header-content">
                    <h3 class="page-company-page__heading">{{$company->name}}</h3>
                    <table class="page-company-page__info-table">
                        <tbody>
                        <tr>
                            <td class="page-company-page__info-table__key">Asukoht</td>
                            <td class="page-company-page__info-table__value">Saaremaa, Kuressaare, Paide tn 34-22</td>
                        </tr>
                        <tr>
                            <td class="page-company-page__info-table__key">Koduleht</td>
                            <td class="page-company-page__info-table__value">
                                <a href="https://www.google.com" target="_blank">https://www.google.com</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="page-company-page__tabs">
                        <ul>
                            <li>
                                <a href="{{route('company.page', ['slug' => $company->slug])}}">
                                    Tutvustus
                                </a>
                            </li>
                            <li class="page-company-page__tabs--active">
                                <a href="#">
                                    Pakkumised
                                    <span class="page-company-page__tabs__count">12</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <div class="container page-company-page__content">
            <div class="row">
                <div class="col-md-8 col-12">
                    Packages GRID
                </div>
                <div class="col-md-4 col-12 mt-5 mt-md-0">
                    <div class="page-company-page__image">
                        <img src="https://www.worldwideinsure.com/travel-blog/wp-content/uploads/2017/12/Hotel-Room-Image-by-Megha01-CC0.jpg" class=""/>
                        <span class="page-company-page__image__gallery">Galerii</span>
                    </div>
                </div>
            </div>
        </div>

        <x-footer type="light"/>
    </div>
@endsection
