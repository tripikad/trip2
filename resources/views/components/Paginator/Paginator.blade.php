@php

$paginator = $paginator ?? null

@endphp

@if ($paginator && $paginator->hasPages())

    <ul class="Paginator">

        @if ($paginator->onFirstPage())
            <li class="Paginator__item Paginator__button Paginator__button--disabled">
                ‹ {{ trans('pagination.previous') }}
            </li>
        @else
            <li class="Paginator__item">
                <a href="{{ $paginator->previousPageUrl() }}" class="Paginator__button" rel="prev">
                    ‹ {{ trans('pagination.previous') }}
                </a>
            </li>
        @endif

        @if ($paginator->hasMorePages())
            <li class="Paginator__item">
                <a  href="{{ $paginator->nextPageUrl() }}" rel="next" class="Paginator__button">
                    {{ trans('pagination.next') }} ›
                </a>
            </li>
        @else
            <li class="Paginator__item Paginator__button Paginator__button--disabled">
                {{ trans('pagination.next') }} ›
            </li>
        @endif

    </ul>

@endif
