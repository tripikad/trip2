@if (count($actions))

<div class="btn-group">

    @foreach($actions as $action)

        <a href="{{ $action['route'] }}" class="btn btn-xs btn-default">{{ $action['title'] }}</a>

    @endforeach

</div>

@endif