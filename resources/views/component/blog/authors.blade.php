<ul class="c-blog-authors">

    @foreach($items as $item)

    <li class="c-blog-authors__item">
        <a href="{{ $item['route'] }}" class="c-blog-authors__item-link">
            <img src="{{ $item['image'] }}" alt="" class="c-blog-authors__item-image">
            <span class="c-blog-authors__item-text">{{ $item['title'] }}</span>
        </a>
    </li>

    @endforeach

</ul>