<div class="modal fade" id="ModalDesMsg" tabindex="-1" role="dialog" aria-labelledby="ModalDesMsgTitle" aria-hidden="true" data-route="{{ route('client.msg.destroy.request', ['msgid' => $msgid]) }}">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalDesMsgTitle">Xóa tin nhắn này</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<input type="hidden" name="mem_id" id="mem_id">
        <p>Xóa không?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="BtnDestroyMsg">Xóa</button>
      </div>
    </div>
  </div>
</div>