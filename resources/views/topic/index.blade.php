@if (count($topics))

    about

    @foreach ($topics as $topic)
      
      <a href="/content/index/forum?topic={{ $topic->id }}">{{ $topic->name }}</a>

    @endforeach

@endif