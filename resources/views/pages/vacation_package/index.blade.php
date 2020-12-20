@extends('layouts.main2')

@section('content')

    <div class="page-vp-index">
        <x-header>
            <div class="page-vp-index__header-content">
                <h3 class="page-vp-index__header-content__heading">Puhkusepaketid</h3>
                <x-tabs :tabs="$categories"/>
            </div>
        </x-header>

        <div class="container page-vp-index__content">
            <div class="row">
                <div class="col-md-9 col-12">
                    @foreach ($packages->chunk(2) as $chunk)
                        <div class="row">
                            @foreach($chunk as $package)
                                <div class="col-md-6 page-vp-index__content__item">
                                    <x-vacation-package.item :package="$package"/>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                </div>
                <div class="col-md-3 col-12 mt-5 mt-md-0">

                    <div id="div-gpt-ad-1465761439447-0" class="Promo"></div>

                    <div class="page-company-page__image">


<!--                        <img src="https://www.worldwideinsure.com/travel-blog/wp-content/uploads/2017/12/Hotel-Room-Image-by-Megha01-CC0.jpg" class=""/>
                        <span class="page-company-page__image__gallery">Galerii</span>-->
                    </div>
                </div>
            </div>
        </div>

        <x-footer/>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        googletag.cmd.push(function() {
            googletag.display('div-gpt-ad-1465761439447-0');
        });
    </script>
@endpush
