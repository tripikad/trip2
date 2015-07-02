<div class="row">

    @foreach ($contents as $index => $content)

        <div class="col-sm-6">

            <div class="row">

                <div class="col-xs-2">
                    
                    <a href="/user/{{ $content->user->id }}">
                        @include('image.circle', ['image' => $content->user->imagePath()])
                    </a>
                
                </div>
                
                <div class="col-xs-10">
                    
                    <h3><a href="/content/{{ $content->id }}">{{ $content->title }}</a></h3>
                    
                    <p>by @include('user.item', ['user' => $content->user])</p>
                
                </div>

            </div>

        </div>

        @if (($index + 1) % 2 == 0) </div><div class="row"> @endif

    @endforeach

</div>