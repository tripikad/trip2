<div class="c-travelmate {{ $modifiers or '' }}">

    <div class="c-travelmate__image">
        <img src="{{ $image }}" alt="">
    </div>

    <p class="c-travelmate__name">
        {{ str_limit($name, 24) }}
        @if(isset($sex_and_age))
            <span>({{ $sex_and_age }})</span>
        @endif
    </p>

    <h3 class="c-travelmate__title">
        {{ $title }}
    </h3>

    <p class="c-travelmate__more">{{ trans('content.action.read.more') }} ›</p>

    @if(isset($tags))

        <div class="c-travelmate__tags">

            @include('component.tags', [
                'modifiers' => 'm-small',
                'items' => $tags
            ])

        </div>

    @endif

</div>
