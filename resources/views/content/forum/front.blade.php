<div class="row">

    @foreach ($contents as $index => $content)

        <div class="col-sm-4">

            <div class="row">

                <div class="col-xs-2">
                    
                    <a href="/user/{{ $content->user->id }}">
                        @include('image.circle', ['image' => $content->user->imagePath()])
                    </a>
                
                </div>
                
                <div class="col-xs-10">
                    
                    <h4><a href="/content/{{ $content->id }}">{{ $content->title }}</a></h4>
                    
                    <p>by @include('user.item', ['user' => $content->user])</p>
                
                </div>

            </div>

        </div>

        @if (($index + 1) % 3 == 0) </div><div class="row"> @endif

    @endforeach

</div>