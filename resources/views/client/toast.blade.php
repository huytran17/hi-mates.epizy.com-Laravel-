<div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="800" id="toast">
  <div class="toast-header">
    <img src="{{ asset('img/logo.png') }}" class="rounded mr-2" alt="...">
    <strong class="mr-auto app-name">{{ config('app.name', 'hi-mates') }}</strong>
    <small class="time-tip">Vừa xong</small>
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="toast-body">
    {{ $content }}
  </div>
</div>

