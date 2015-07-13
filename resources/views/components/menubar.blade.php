<div class="row">

    <div class="col-sm-1 text-center">
        <h1><a href="/">{{ config('site.name') }}</a></h1>
    </div>

    <div class="col-sm-9 text-center">

        <ul class="nav nav-pills">

        @foreach (config('content.types') as $type => $data)
            <li>
                <a href="{{ route('content.index', ['type' => $type]) }}">
                    {{ trans("content.$type.index.title") }}
                </a>
            </li>
        @endforeach

        </ul>

    </div>

    <div class="col-sm-2 text-center">
        
        @include('components.auth.menu')
    
    </div>

</div>