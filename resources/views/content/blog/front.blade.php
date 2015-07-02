<div class="row">

    @foreach ($contents as $content)

        <div class="col-sm-2 text-center">

            <div style="padding: 15px;">
                <a href="/content/{{ $content->id }}">
                    @include('image.circle', ['image' => $content->user->imagePath()])
                </a>
            </div>

            <p style="margin-top: 10px">
                {{ $content->user->name }}
            </p>

            <h4 style="margin-top: 10px">{{ str_limit($content->title, 40) }}</h4>

        </div>

    @endforeach

</div>