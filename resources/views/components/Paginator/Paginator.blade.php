@if ($paginator->hasPages())

    <ul class="Paginator">

        @if ($paginator->onFirstPage())
            <li class="Paginator__button Paginator__button--disabled">
                ‹ {{ trans('pagination.previous') }}
            </li>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">
                <li class="Paginator__button">
                    ‹ {{ trans('pagination.previous') }}
                </li>
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">
                <li class="Paginator__button">
                    {{ trans('pagination.next') }} ›
                </li>
            </a>
        @else
            <li class="Paginator__button Paginator__button--disabled">
                {{ trans('pagination.next') }} ›
            </li>
        @endif

    </ul>
    
@endif
