<div class="modal fade" id="ModalDesMem" tabindex="-1" role="dialog" aria-labelledby="ModalDesMesTitle" aria-hidden="true" data-route="{{ route('client.team.desMember.request', ['teamid' => $teamID, 'memid' => $memID]) }}">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalDesMesTitle">Xóa thành viên</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<input type="hidden" name="mem_id" id="mem_id">
        <p>Xóa không?</p>
      </div>
      <div class="modal-footer">
        <button type="button" id="BtnDestroyMem">Xóa</button>
      </div>
    </div>
  </div>
</div>