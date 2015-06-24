@if (count($topics))

    about

    @foreach ($topics as $topic)
      
      <em>{{ $topic->name }}</em>

    @endforeach

@endif