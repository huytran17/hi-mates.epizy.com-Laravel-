<div class="modal fade" id="ModalChgColor" tabindex="-1" role="dialog" aria-labelledby="ModalChgColorTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalChgColorTitle">Thay đổi màu sắc</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form data-route="{{ route('client.team.chgcolor.request', ['teamID' => $teamID]) }}" id="form_chgtmcolor">
                    @csrf
                    <div class="form-group row">
                        <label for="tm_color" class="col-md-4 col-form-label text-md-right">{{ __('Chọn màu') }}</label>
                        <div class="col-md-6">
                            <input id="tm_color" type="color" name="tm_color" class="form-control" tm_color="tm_color" value="{{ $color }}" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="BtnChgColor">Lưu</button>
            </div>
        </div>
    </div>
</div>
