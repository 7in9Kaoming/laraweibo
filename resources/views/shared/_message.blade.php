@foreach(['danger', 'warning', 'success', 'info'] as $msg)
  @if(session()->has($msg))
    <div class="alert alert-{{ $msg }}" role="alert">
      {{ session()->get($msg) }}
	</div>
  @endif
@endforeach
