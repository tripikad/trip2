<div class="c-search {{ $modifiers or '' }}">

    <div class="c-search__form">

        <span class="c-search__form-icon">

            @include('component.svg.sprite', [
                'name' => 'icon-search'
            ])

        </span>

        <input type="text" class="c-search__form-input" placeholder="{{ $placeholder }}">
    </div>
</div>
