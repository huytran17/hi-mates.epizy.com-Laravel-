	<div class="message-frame">
		<div class="frame-header">
			<div class="team-title">
				<h4>{{ $team->name }}</h4>
				<x-message-functions :teamMaker="$team->created_by" :teamID="$team->encrypted_id" />
			</div>
			<div class="count-members">
				<span>{{ $team->users_count }}</span>&nbsp;thành viên
			</div>
			<div class="join-code">
				<span>ID nhóm: {{ $team->join_code }}</span>
				<x-team-renew-join-code :teamID="$team->encrypted_id" />
			</div>
		</div>
	    <div class="frame-body">
	    	<ul id="messages" teamid="{{ $team->encrypted_id }}" uid="{{ auth()->user()->encrypted_id }}" style="background-image: url('{{ $team->team_data->background }}');" onscroll="loadMoreMessages(event)">
		    	@foreach(array_reverse($team->messages) as $msg)
		    		<x-message-item class="{{ $msg->user_id===auth()->id() ? 'm-dr' : 'm-dl' }}" data-placement="{{ $msg->user_id===auth()->id() ? 'right' : 'left' }}" :msg="json_encode($msg)" style="background-color: {{ $team->team_data->color }};" />
		    	@endforeach
		    </ul>
	    </div>
	    <div class="frame-footer">
	    	<x-message-input />
	    </div>
	</div>
