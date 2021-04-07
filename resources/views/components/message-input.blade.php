<div class="msg-input">
    <div id="PreviewReply" class="d-none fz-sm">
        <p id="ReplyTag"></p>
        <span class="far fa-times"></span>
    </div>
   <div id="PreviewAttachment">
        <div id="PreviewImg" class="d-none fz-md">
            <div>
                <img src="" alt="">
            </div>
            <div>
                <span class="fal fa-check" data-route="{{ route('client.msg.storeimg.request') }}"></span>
                <span class="fal fa-times"></span>   
            </div>
        </div>
        <div id="PreviewFile" class="d-none fz-md">
            <div>
                <p class="file-name"></p>
            </div>
            <div>
                <span class="far fa-check" data-route="{{ route('client.msg.storedoc.request') }}"></span>
                <span class="far fa-times"></span>
            </div>
        </div>
   </div>
    <form data-route="{{ route('client.msg.store.request') }}" id="FormSendMsg" enctype="multipart/form-data">
        <div class="attachment fz-md">
            <div class="options">
                <div class="expand">
                    <i class="fal fa-plus-circle" id="BtnExpAtt"></i>
                </div>
                <div class="option-items">
                    <label for="msg_file"><i class="fal fa-paperclip"></i></label>
                    <input type="file" name="msg_file" id="msg_file" accept=".doc,.docx,.ppt,.pptx,.pdf,.txt">
                    <label for="msg_img"><i class="fal fa-images"></i></label>
                    <input type="file" name="msg_img" id="msg_img" accept="image/*">
                    <label>
                        <div id="voice">
                            <div id="PreviewRecord" class="fz-md" style="display: none;">
                                <span class="far fa-check" data-route="{{ route('client.msg.storeaudio.request') }}"></span>
                                <span class="far fa-times"></span>
                            </div>
                            <div class="record-btn" class="fz-md" style="display: none;">
                                <i class="far fa-circle" id="StartRecord"></i>
                                <i class="far fa-pause-circle" id="PauseRecord"></i>
                                <i class="far fa-stop-circle" id="StopRecord"></i>
                            </div>
                        </div>
                        <i class="fal fa-headset fz-md" id="Record" data-route="{{ route('client.msg.storeaudio.request') }}"></i>
                    </label>
                </div>
            </div>
        </div>
        <div class="type-area">
            <textarea type="text" name="content" id="content" required placeholder="Abc..."></textarea>
            <div class="btn-send-msg">
                <div>
                    <i class="fal fa-paper-plane fz-lg" id="BtnSendMsg" disabled></i>
                </div>
            </div>
        </div>
    </form>
</div>
