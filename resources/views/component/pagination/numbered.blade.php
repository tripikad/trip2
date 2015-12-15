{{--

title: Numbered pagination

code: |

    @include('component.pagination.numbered', [
        'collection' => false,
        'text' => [
            'next' => '›',
            'previous' => '‹',
        ]
    ])

--}}

@if ($collection)
    @if ((method_exists($collection, 'lastPage')) || (! empty($collection->nextPageUrl()) || ! empty($collection->previousPageUrl())))

        <ul class="c-pagination m-numbered">

            <li class="c-pagination__item">

                @if ($collection->currentPage() != 1)

                    <a href="{{ $collection->previousPageUrl() }}" class="c-pagination__item-link m-previous">

                @else

                    <span class="c-pagination__item-text m-previous m-disabled">

                @endif

                @if (isset($text) && !empty($text) && $text['previous'])

                    {{  $text['previous'] }}

                @else

                    ‹

                @endif

                @if ($collection->currentPage() != 1)

                    </a>

                @else

                    </span>

                @endif

            </li>

            @if (method_exists($collection, 'lastPage'))

                @if ($collection->lastPage() > 1)

                    @for ($i = 1; $i <= $collection->lastPage(); $i++)

                        <li class="c-pagination__item">

                            @if ($collection->currentPage() == $i)

                                <span class="c-pagination__item-text m-disabled">

                            @else

                                <a href="{{ $collection->url($i) }}" class="c-pagination__item-link">

                            @endif

                                {{ $i }}

                            @if ($collection->currentPage() == $i)

                                </span>

                            @else

                                </a>

                            @endif

                        </li>

                    @endfor

                @endif

            @endif

            <li class="c-pagination__item">

                @if (! empty($collection->nextPageUrl()))

                    <a href="{{ $collection->nextPageUrl() }}" class="c-pagination__item-link m-next">

                @else

                    <span class="c-pagination__item-text m-next m-disabled">

                @endif

                @if (isset($text) && !empty($text) && $text['next'])

                    {{  $text['next'] }}

                @else

                    ›

                @endif

                @if (! empty($collection->nextPageUrl()))

                    </a>

                @else

                    </span>

                @endif

            </li>

        </ul>

    @endif
@endif
