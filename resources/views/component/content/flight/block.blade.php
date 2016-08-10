<ul class="c-flight-list">

    @foreach ($items as $item)

    <li class="c-flight-list__item">

        <a href="{{ $item['route'] }}" class="c-flight-list__image" style="background-image: url({{ $item['image'] }});"></a>

        <h3 class="c-flight-list__title"><a href="{{ $item['route'] }}" class="c-flight-list__title-link">{{ $item['title'] }} <span class="m-red">{{ $item['price'] }}</span></a></h3>

        {!! $item['meta'] !!}

    </li>

    @endforeach

</ul>