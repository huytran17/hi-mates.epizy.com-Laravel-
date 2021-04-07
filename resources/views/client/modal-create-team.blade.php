<div class="modal fade" id="ModalCreateTeam" tabindex="-1" role="dialog" aria-labelledby="ModalCreateTeamTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalCreateTeamTitle">Tạo nhóm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="FormCreateTeam" data-route="{{ route('client.team.store.request') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="team_name" class="col-md-4 col-form-label text-md-right">{{ __('Tên nhóm') }}</label>
                        <div class="col-md-6">
                            <input type="text" name="team_name" id="team_name" class="form-control" required autocomplete="team_name" autofocus>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" form="FormCreateTeam" id="BtnCreateTeam">Tạo</button>
            </div>
        </div>
    </div>
</div>
