<div class="modal fade" id="ModalAddMem" tabindex="-1" role="dialog" aria-labelledby="ModalAddMemTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable|modal-dialog-centered modal-sm|modal-lg|modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalAddMemTitle">Thêm thành viên</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form data-route="{{ route('client.team.storemem.request', ['teamID' => $teamID]) }}" id="FormAddMem">
		      		@csrf
		      		<div class="form-group row">
	                    <label for="addname" class="col-md-4 col-form-label text-md-right">{{ __('Tên người dùng') }}</label>

	                    <div class="col-md-6">
	                        <input id="addname" type="text" class="form-control" name="addname" required autocomplete="addname" autofocus>
	                    </div>
	                </div>
		      	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" form="FormAddMem" id="BtnAddMem">Thêm</button>
      </div>
    </div>
  </div>
</div>