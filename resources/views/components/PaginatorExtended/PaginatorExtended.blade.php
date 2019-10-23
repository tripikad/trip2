@php

$paginator = $paginator ?? null

@endphp

@if ($paginator && $paginator->hasPages())

    <ul class="Paginator">

        @if ($paginator->onFirstPage())
            <li class="Paginator__item Paginator__button Paginator__button--disabled">
                ‹‹
            </li>
        @else

            <li class="Paginator__item">
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="Paginator__button">
                    ‹‹
                </a>
            </li>

        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="Paginator__item Paginator__button Paginator__button--disabled">{{ $element }}</li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="Paginator__item Paginator__button Paginator__button--active">{{ $page }}</li>
                    @else
                        <li class="Paginator__item"><a class="Paginator__button" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li href="{{ $paginator->nextPageUrl() }}" class="Paginator__item">
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="Paginator__button">
                    ››
                </a>
            </li>
        @else
            <li class="Paginator__item Paginator__button Paginator__button--disabled">
                ››
            </li>
        @endif

    </ul>

@endif
