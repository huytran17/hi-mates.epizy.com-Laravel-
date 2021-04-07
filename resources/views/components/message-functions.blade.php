<div class="msg-funcs">
    <div class="btn-add-mem" title="Thêm thành viên">
        <i class="fal fa-users-medical" id="AddMemModal" data-route="{{ route('client.team.add', ['teamID' => $teamID]) }}"></i>
    </div>
    <div id="video">
        <i class="fal fa-video" id="OpenCallWindow" onclick="openCallWindow()" title="Gọi video"></i>
    </div>
    <div class="team-funcs" id="TeamFuncs">
        <div class="dropdown">
            <i class="fal fa-cog" data-toggle="dropdown" title="Cài đặt"></i>
            <ul class="dropdown-menu dropdown-menu-right">
                <li class="dropdown-item fz-md" id="TeamColorModal" data-route="{{ route('client.team.chgclmd', ['teamID' => $teamID]) }}">Màu sắc</li>
                <li class="dropdown-item fz-md" id="TeamBgModal" data-route="{{ route('client.team.chgbgmd', ['teamID' => $teamID]) }}">Hình nền</li>
                <li class="dropdown-item fz-md" id="TeamNameModal" data-route="{{ route('client.team.chgnamemd', ['teamID' => $teamID]) }}">Nhóm</li>
                <li class="dropdown-item fz-md" id="TeamLeaveModal" data-route="{{ route('client.team.leavemd', ['teamID' => $teamID]) }}">Rời nhóm</li>
                @if (auth()->id() === $teamMaker)
                <li class="dropdown-item fz-md" id="TeamDesModal" data-route="{{ route('client.team.destroymd', ['teamID' => $teamID]) }}">Xóa nhóm</li>
                @endif
            </ul>
        </div>
    </div>
</div>
