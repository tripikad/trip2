@if ((method_exists($collection, 'lastPage')) || (! empty($collection->nextPageUrl()) || ! empty($collection->previousPageUrl())))

    <ul class="c-pagination">

        <li class="c-pagination__item{{ ($collection->currentPage() == 1) ? ' disabled' : '' }}">

            @if ($collection->currentPage() != 1)

                <a href="{{ $collection->previousPageUrl() }}" class="c-pagination__item-text">

            @else

                <span class="c-pagination__item-text">

            @endif

            {{ trans('pagination.previous') }}

            @if ($collection->currentPage() != 1)

                </a>

            @else

                </span>

            @endif

        </li>
        @if(method_exists($collection, 'lastPage'))
            @if($collection->lastPage() > 1)

                @for ($i = 1; $i <= $collection->lastPage(); $i++)

                    <li class="c-pagination__item{{ ($collection->currentPage() == $i) ? ' active' : '' }}">

                        <a href="{{ $collection->url($i) }}" class="c-pagination__item-text">

                            {{ $i }}

                        </a>

                    </li>

                @endfor

            @endif
        @endif

        <li class="c-pagination__item{{ empty($collection->nextPageUrl()) ? ' disabled' : '' }}">

            @if (! empty($collection->nextPageUrl()))

                <a href="{{ $collection->nextPageUrl() }}" class="c-pagination__item-text">
            @else

                <span class="c-pagination__item-text">

            @endif

            {{ trans('pagination.next') }}

            @if (! empty($collection->nextPageUrl()))

                </a>

            @else

                </span>

            @endif

        </li>

    </ul>

@endif
