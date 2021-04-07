@foreach(array_reverse($messages) as $msg)
	<x-message-item class="{{ $msg['user_id']===auth()->id() ? 'm-dr' : 'm-dl' }}" :msg="json_encode($msg)" style="background-color: {{ $team->team_data->color }};" />
@endforeach