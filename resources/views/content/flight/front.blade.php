<div class="row">

    @foreach ($contents as $content)

        <div class="col-sm-6">

            <a href="/content/{{ $content->id }}">

                @include('component.card', [
                    'title' => $content->title,
                    ])
                    
            </a>

        </div>

        @if (($index + 1) % 2 == 0) </div><div class="row"> @endif

    @endforeach

</div>