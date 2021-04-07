<div class="card">
    <div class="card-header" id="headingMem">
        <div data-toggle="collapse" data-target="#collapseMem" aria-expanded="true" aria-controls="collapseMem">
            <b>Thành viên</b> <span class="fal fa-sync" id="RefreshTmMem" data-route="{{ route('client.team.refreshtmmem', ['teamid' => $team->encrypted_id]) }}"></span>
        </div>
    </div>
    <div id="collapseMem" class="collapse show" aria-labelledby="headingMem" data-parent="#accordionMember">
        <div class="card-body">
            <ul class="list-members list">
                @foreach($team->users as $mem)
                <li class="mem-item" data-route="{{ route('client.user.meminfo', ['id' => $mem->encrypted_id, 'teamID' => $team->encrypted_id]) }}">
                    <div class="mem">
                        <img src="{{ $mem->profile_photo_path }}" alt="{{ $mem->slug }}">
                        <span id="MemName">
                            {{ $mem->name }} {!! $mem->pivot->nickname!==null ? '('.$mem->pivot->nickname.')' : '' !!}
                        </span>
                        @if($mem->id === $team->created_by)
                        <div class="owner">
                            <i class="fal fa-stars"></i>
                        </div>
                        @endif
                        @if(auth()->id() === $team->created_by && $mem->id !== auth()->id())
                        <div id="MemDesModal" data-route="{{ route('client.team.destroymem', ['memID' => $mem->encrypted_id, 'teamID' => $team->encrypted_id]) }}">
                            <i class="fal fa-trash"></i>
                        </div>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
