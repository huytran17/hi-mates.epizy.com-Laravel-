
<div class="modal fade" id="ModalLeaveTeam" tabindex="-1" role="dialog" aria-labelledby="ModalLeaveTeamTitle" aria-hidden="true" data-route="{{ route('client.team.leave.request', ['id' => $teamID]) }}">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLeaveTeamTitle">Rời nhóm</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Rời không?</p>
      </div>
      <div class="modal-footer">
        <button type="button" id="BtnLeaveTeam">Rời</button>
      </div>
    </div>
  </div>
</div>