<ul class="c-travelmate-list {{ $modifiers or '' }}">

    @foreach($items as $item)

    <li class="c-travelmate-list__item">

        <a href="{{ $item['route'] }}" class="c-travelmate-list__link">

            @include('component.travelmate', [
                'modifiers' => $item['modifiers'],
                'image' => $item['image'],
                'name' => $item['name'],
                'sex_and_age' => $item['sex_and_age'],
                'title' => $item['title'],
                'tags' => $item['tags']
            ])

        </a>

    </li>

    @endforeach

</ul>