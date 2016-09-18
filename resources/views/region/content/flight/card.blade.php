@if (isset($items) && count($items))
    <div class="c-columns m-{{ count($items) }}-cols">

        @foreach ($items as $item)

            <div class="c-columns__item">
                @include('component.card', [
                    'modifiers' => 'm-purple',
                    'route' => route($item->type.'.show', [$item->slug]),
                    'title' => $item->title.' '.$item->price.config('site.currency.symbol'),
                    'image' => $item->imagePreset()
                ])
            </div>

        @endforeach

    </div>
@endif
