@foreach ($flags as $flag)
  {{ $flag->flag_type }} @include('user.item', ['user' => $flag->user]) 
@endforeach