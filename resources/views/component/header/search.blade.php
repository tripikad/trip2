@inject('request', 'Illuminate\Http\Request')

<div class="c-search js-search {{ $modifiers or '' }}">
    <form action="/search" method="get" id="global_search_form">
        <div class="c-search__form">
            <input type="text" name="q" id="search_small" class="c-search__form-input js-search__form-input" placeholder="{{ $placeholder }}" autocomplete="off" value="{{$request->get('q')}}">
            <label for="search_small" class="c-search__form-icon js-search__form-icon">
                @include('component.svg.sprite', [
                    'name' => 'icon-search'
                ])
            </label>
        </div>
    </form>
    <div class="c-search__results" id="search_results_div"></div>
</div>
