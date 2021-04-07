<div class="modal fade" id="ModalJoinTeam" tabindex="-1" role="dialog" aria-labelledby="ModalJoinTeamTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalJoinTeamTitle">Tham gia nhóm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form data-route="{{ route('client.team.join.request') }}" id="FormJoinTeam">
                    @csrf
                    <div class="form-group row">
                        <label for="join_code" class="col-md-4 col-form-label text-md-right">{{ __('Nhập ID nhóm') }}</label>
                        <div class="col-md-6">
                            <input type="text" name="join_code" id="join_code" class="form-control" required autocomplete="join_code" autofocus>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" form="FormJoinTeam" id="BtnJoinTeam">Tham gia</button>
            </div>
        </div>
    </div>
</div>
