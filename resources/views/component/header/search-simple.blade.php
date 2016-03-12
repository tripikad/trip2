<div class="c-search-simple {{$modifiers or ''}}">

    <div class="c-search-simple__form">

        <span class="c-search-simple__form-icon js-search__form-icon">

            @include('component.svg.sprite', [
                'name' => 'icon-search'
            ])

        </span>

        <input type="text" class="c-search-simple__form-input js-search__form-input" placeholder="{{ $placeholder }}">
    </div>
</div>