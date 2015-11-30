<div class="c-user-destination">

    @foreach ($destinations as $key => $destination)

        @if (isset($destination->flaggable))

            <span class="c-user-destination__item m-box">
                <a href="{{ route('flag.toggle', ['destination', $destination->flaggable, $destination->flag_type]) }}"
                    class="c-user-destination__item-link {{ $modifiers or '' }}"
                    {!! (isset($title) ? ' title="' . $title . '"' : '')  !!}>

                    <span class="c-user-destination__item-text">
                        {{ $destination->flaggable->name }}
                    </span>

                    <span class="c-user-destination__item-remove js-visibility">×</span>
                </a>
            </span>

        @endif

    @endforeach

</div>
