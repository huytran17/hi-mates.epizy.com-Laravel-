@foreach($teams as $team)
	<li class="team-tag" data-route="{{ route('client.team.view', ['id' => $team->encrypted_id]) }}" title="{{ $team->name }}">
    	<div class="tag-container">
    		<div class="tag">
    			<span class="tag-item">{{ $team->name }}</span>
    		</div>
    	</div>
	</li>
@endforeach
