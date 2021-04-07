<div class="modal fade" id="ModalChgBg" tabindex="-1" role="dialog" aria-labelledby="ModalChgBgTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalChgBgTitle">Thay đổi hình nền</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form data-route="{{ route('client.team.chgbg.request', ['teamID' => $teamID]) }}" enctype="multipart/form-data" id="form_chgtmbg">
                    @csrf
                    <div class="form-group row">
                        <label for="tm_bg" class="col-md-4 col-form-label text-md-right">{{ __('Chọn ảnh') }}</label>
                        <div class="col-md-6">
                            <input id="tm_bg" type="file" class="form-control-file" name="tm_bg" accept="image/*" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="BtnDesBg" data-route="{{ route('client.team.desbg', ['teamID' => $teamID]) }}">Xóa nền</button>
                <button type="button" id="BtnChgBg">Lưu</button>
            </div>
        </div>
    </div>
</div>
