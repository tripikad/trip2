{{--

title: Pagination

code: |

    @include('component.pagination.default', [
        'collection' => false,
        'text' => [
            'next' => 'Next',
            'previous' => 'Previous',
        ]
    ])

--}}

@if ($collection)
    @if ((method_exists($collection, 'lastPage')) || (! empty($collection->nextPageUrl()) || ! empty($collection->previousPageUrl())))

        <ul class="c-pagination">

            <li class="c-pagination__item

            {{ ($collection->currentPage() == 1) ? ' disabled' : '' }}

            @if (! method_exists($collection, 'lastPage') || $collection->lastPage() <= 1)

                    m-first

            @endif

            ">

                @if ($collection->currentPage() != 1)

                    <a href="{{ $collection->previousPageUrl() }}" class="c-pagination__item-text m-icon-pre c-button m-tertiary m-small">

                @else

                    <span class="c-pagination__item-text m-icon-pre c-button m-tertiary m-small">

                @endif

                @if (isset($text) && !empty($text) && $text['previous'])

                    {{  $text['previous'] }}

                @else

                    {{ trans('pagination.previous') }}

                @endif

                <span class="c-button__icon">

                    @include('component.svg.sprite', ['name' => 'icon-arrow-left'])

                </span>

                @if ($collection->currentPage() != 1)

                    </a>

                @else

                    </span>

                @endif

            </li>

            @if (method_exists($collection, 'lastPage') && isset($numbered))

                @if ($collection->lastPage() > 1)

                    @for ($i = 1; $i <= $collection->lastPage(); $i++)

                        <li class="c-pagination__item{{ ($collection->currentPage() == $i) ? ' active' : '' }}">

                            <a href="{{ $collection->url($i) }}" class="c-pagination__item-text c-button m-tertiary m-small">

                                {{ $i }}

                            </a>

                        </li>

                    @endfor

                @endif

            @endif

            <li class="c-pagination__item

                {{ empty($collection->nextPageUrl()) ? ' disabled' : '' }}

                @if ((! method_exists($collection, 'lastPage') || $collection->lastPage() <= 1) || ! isset($numbered))

                    m-last

                @endif
            ">

                @if (! empty($collection->nextPageUrl()))

                    <a href="{{ $collection->nextPageUrl() }}" class="c-pagination__item-text m-icon-post c-button m-tertiary m-small">
                @else

                    <span class="c-pagination__item-text m-icon-post c-button m-tertiary m-small">

                @endif

                    @if (isset($text) && !empty($text) && $text['next'])

                        {{  $text['next'] }}

                    @else

                        {{ trans('pagination.next') }}

                    @endif

                    <span class="c-button__icon">

                        @include('component.svg.sprite', ['name' => 'icon-arrow-right'])

                    </span>

                @if (! empty($collection->nextPageUrl()))

                    </a>

                @else

                    </span>

                @endif

            </li>

        </ul>

    @endif
@endif
