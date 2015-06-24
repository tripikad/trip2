@foreach ($flags as $flag)
  {{ $flag->flag_type }} @include('user.show', ['user' => $flag->user]) 
@endforeach