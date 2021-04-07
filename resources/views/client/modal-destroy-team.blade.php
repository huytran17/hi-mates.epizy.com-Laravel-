
<div class="modal fade" id="ModalDestroyTeam" tabindex="-1" role="dialog" aria-labelledby="ModalDestroyTeamTitle" aria-hidden="true" data-route="{{ route('client.team.destroy.request', ['id' => $teamID]) }}">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalDestroyTeamTitle">Xóa nhóm</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="team_id" id="team_id">
        <p>Xóa không?</p>
      </div>
      <div class="modal-footer">
        <button type="button" id="BtnDestroyTeam">Xóa</button>
      </div>
    </div>
  </div>
</div>