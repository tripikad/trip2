{{--

title: Numbered pagination

code: |

    @include('component.pagination.numbered', [
        'collection' => false
    ])

--}}

<ul class="c-pagination m-numbered">

    <li class="c-pagination__item">
        <span class="c-pagination__item-text m-previous m-disabled">‹</span>
    </li>
    <li class="c-pagination__item">
        <span class="c-pagination__item-text m-disabled">1</span>
    </li>
    <li class="c-pagination__item">
        <a href="#" class="c-pagination__item-link">2</a>
    </li>
    <li class="c-pagination__item">
        <a href="#" class="c-pagination__item-link">3</a>
    </li>
    <li class="c-pagination__item">
        <a href="#" class="c-pagination__item-link m-next">›</a>
    </li>
</ul>