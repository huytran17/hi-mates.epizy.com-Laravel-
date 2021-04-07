<div class="modal fade" id="ModalMemInfo" tabindex="-1" role="dialog" aria-labelledby="ModalMemInfoTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalMemInfoTitle">Thông tin thành viên</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="member-detail">
                    <div class="container">
                        <div class="details">
                            <div class="card bg-light text-dark">
                                <img src="{{ $member->profile_photo_path }}" alt="{{ $member->slug }}" width="80" height="80" class="rounded-circle mx-auto mt-2">
                                <div class="card-body">
                                    <p class="card-text">{{ $member->name }}</p>
                                    <p class="card-text">Ngày tham gia: {{ $member->dmy_created_at }}</p>
                                    <form data-route="{{ route('client.user.udtnickname.request', ['id' => $member->encrypted_id]) }}" method="POST" enctype="multipart/form-data" id="FormChgNickname">
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label for="nickname">Biệt danh:</label>
                                                <input id="nickname" type="text" class="form-control" name="nickname" autocomplete="nickname" autofocus required>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="BtnChgNickname">Lưu</button>
            </div>
        </div>
    </div>
</div>
