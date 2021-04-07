<div class="accordion {{ $attributes['class'] }}" id="accordionTeam">
  <div class="card">
    <div class="card-header" id="headingTeam">
      	<div data-toggle="collapse" data-target="#collapseTeam" aria-expanded="true" aria-controls="collapseTeam">
          	<b>Nhóm của bạn</b> <span class="fal fa-sync" id="RefreshTm" data-route="{{ route('client.team.refreshlist') }}"></span>
        </div>
    </div>

    <div id="collapseTeam" class="collapse show" aria-labelledby="headingTeam" data-parent="#accordionTeam">
      <div class="card-body">
        <ul class="list-teams list">
	   		<x-list-team-tag :teams="$teams" />
	   	</ul>
      </div>
    </div>
  </div>
</div>