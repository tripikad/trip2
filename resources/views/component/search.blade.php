@inject('request', 'Illuminate\Http\Request')

<div class="c-search js-search {{ $modifiers or '' }}">

<form action="/search" method="get" id="global_search_form">

    <div class="c-search__form">

        <span class="c-search__form-icon">
            @include('component.svg.sprite', [
                'name' => 'icon-search'
            ])

        </span>

        <input type="text" name="q" class="c-search__form-input js-search__form-input" placeholder="{{ $placeholder }}" autocomplete="off" value="{{$request->get('q')}}">
        
    </div>

</form>

    <div class="c-search__results" id="search_results_div">

    </div>
</div>
