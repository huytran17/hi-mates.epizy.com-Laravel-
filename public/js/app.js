const APP_DOMAIN = `https://${location.hostname}`;

$(document).on('hidden.bs.modal', e => {
    e.target.remove();
});

$(document).on('hidden.bs.toast', e => {
    e.target.remove();
});

$(document).on('keydown', '#content', event => {
    let key = event.which || event.keyCode;
    if (key == 13) {
        event.preventDefault();
        if (document.body.contains(document.getElementById('BtnSendMsg'))) $('#BtnSendMsg').click();
        else if (document.body.contains(document.getElementById('BtnReplyMsg'))) $('#BtnReplyMsg').click();
        else return false;
    }
});

$(document).on('click', '.move-link', function(event) {
    event.preventDefault();
    document.getElementById($(this).attr('id')).scrollIntoView();
    $(document.getElementById($(this).attr('id'))).find('.msg-content').animate({
        opacity: .5
    }, 200, function() {
        $(this).animate({
            opacity: 1
        }, 200)
    });
});

function openCallWindow(event) {
    window.open(`${APP_DOMAIN}/call?team=` + $('#messages').attr('teamid'), '_blank', "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=100,width=1000,height=600");
};

function resetFormMessageData() {
    $('#FormSendMsg').data({
        parentid: '',
        reproute: '',
    });
    $('#PreviewReply span').click();
    $('#FormSendMsg .btn-send-msg .fa-paper-plane').attr('id', 'BtnSendMsg');
};

$(document).on('click', '.func-item .fa-reply', function() {
    let li = $(this).closest('li');
    $('#ReplyTag').html('Trả lời <b>' + li.find('.sender span').html() + '</b>: ' + li.find('.msg-content .content').html());
    $('#PreviewReply').removeClass('d-none');
    $('#content').focus();
    $('#BtnSendMsg').prop('id', 'BtnReplyMsg');
    $('#FormSendMsg').data({
        parentid: $(this).closest('li').attr('id'),
        reproute: $(this).data('route')
    });
});

$(document).on('change', '#msg_img', function(event) {
    if (event.target.value) {
        let match = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/webp'],
            file_data = $(this).prop('files')[0],
            file_type = file_data.type,
            url = window.URL || window.webkitURL;
        if (match.includes(file_type)) {
            $('#PreviewImg').removeClass('d-none');
            $('#PreviewImg img').prop({
                src: url.createObjectURL(file_data),
                alt: file_data.name,
            });
        } else {
            $('#PreviewImg span:last').click();
            return false;
        }
    } else {
        $('#PreviewImg span:last').click();
        return false;
    }
});

$(document).on('click', '#PreviewImg span:last', event => {
    $('#PreviewImg img').removeAttr('src').removeAttr('alt');
    $('#PreviewImg').addClass('d-none');
    $('#msg_img').val('');
    resetFormMessageData();
});

$(document).on('change', '#msg_file', function(event) {
    if (event.target.value) {
        let match = ['text/plain', 'application/msword', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/pdf', 'audio/*', 'video/*'],
            file_data = $(this).prop('files')[0],
            file_type = file_data.type,
            file_name = file_data.name;
        if (match.includes(file_type)) {
            $('#PreviewFile').removeClass('d-none');
            $('#PreviewFile .file-name').html(file_name);
        } else {
            $('#PreviewFile span:last').click();
            return false;
        }
    } else {
        $('#PreviewFile span:last').click();
        return false;
    }
});

$(document).on('click', '#BtnExpAtt', function(event) {
    $({
        deg: $('.option-items').is(':visible') ? 360 : 0
    }).animate({
        deg: $('.option-items').is(':visible') ? 0 : 360
    }, {
        duration: 500,
        step: function(now) {
            $(event.target).css({
                transform: 'rotate(' + now + 'deg)'
            });
        }
    });
    $('.option-items').toggle('500');
});

$(document).on('click', '#PreviewFile span:last', event => {
    $('#PreviewFile p').empty();
    $('#PreviewFile').addClass('d-none');
    $('#msg_file').val('');
    resetFormMessageData();
});

$(document).on('click', '#PreviewReply span', () => {
    $('#FormSendMsg').data({
        parentid: '',
        reproute: '',
    });
    $('#FormSendMsg .btn-send-msg .fa-paper-plane').attr('id', 'BtnSendMsg');
    $('#PreviewReply').addClass('d-none');
});

$(document).on('click', '#BtnChgNickname', async () => {
    await user.changeNickname();
});

async function loadMoreMessages(e) {
    await user.loadMoreMessages(e);
}

$(document).on('click', '.msg-content img', async e => {
    await user.viewMessageImage(e);
});

$(document).on('click', '#BtnSendMsg', async () => {
    await user.sendMessage();
});

$(document).on('click', '#BtnReplyMsg', async () => {
    await user.replyMessage();
});

$('#CreateTeamModal').click(async e => {
    e.preventDefault();
    await user.getCreateTeamModal(e);
});

$('#JoinTeamModal').click(async e => {
    e.preventDefault();
    await user.getJoinTeamModal(e);
});

$(document).on('click', '#BtnCreateTeam', async () => {
    await user.createTeam();
});

$(document).on('click', '#BtnJoinTeam', async () => {
    await user.joinTeam();
})

$(document).on('click', '.list-teams .team-tag', async e => {
    await user.viewTeamMessage(e);
});

$(document).on('click', '#AddMemModal', async e => {
    await user.getAddMemModal(e);
});

$(document).on('click', '#BtnAddMem', async () => {
    await user.addMember();
});

$(document).on('click', '#RenewJoinCode', async e => {
    await user.renewJoinCode(e);
});

$(document).on('click', '#TeamNameModal', async e => {
    await user.getChangeTeamNameModal(e);
});

$(document).on('click', '#TeamColorModal', async e => {
    await user.getChangeColorModal(e);
});

$(document).on('click', '#TeamBgModal', async e => {
    await user.getChangeBackgroundModal(e);
});

$(document).on('click', '#TeamLeaveModal', async e => {
    await user.getLeaveTeamModal(e);
});

$(document).on('click', '#accordionMember .mem-item', async e => {
    await user.getMemberInfoModal(e);
});

$(document).on('click', '#TeamDesModal', async e => {
    await user.getDestroyTeamModal(e);
});

$(document).on('click', '#MemDesModal', async e => {
    await user.getDestroyMemberModal(e);
});

$(document).on('click', '.msg-item .items i:last-child', async e => {
    await user.getDestroyMessageModal(e);
});

$(document).on('click', '#BtnDestroyMsg', async e => {
    e.preventDefault();
    await user.destroyMessage();
});

$(document).on('click', '#BtnChgBg', async e => {
    e.preventDefault();
    await user.changeBackground();
});

$(document).on('click', '#PreviewImg span:first', async e => {
    await user.sendImageMessage(e);
});

$(document).on('click', '#PreviewFile span:first', async e => {
    await user.sendFileMessage(e);
});

$(document).on('click', '#RefreshTm', async () => {
    await user.refreshListTeam();
});

$(document).on('click', '#RefreshTmMem', async () => {
    await user.refreshTeamMember();
});

$(document).on('click', '#BtnChangeTeamName', async () => {
    await user.changeTeamName();
});

$(document).on('click', '#BtnChgColor', async () => {
    await user.changeColor();
});

$(document).on('click', '#BtnDesBg', async e => {
    await user.destroyBackground(e);
});

$(document).on('click', '#BtnDestroyMem', async () => {
    await user.destroyMember();
});

$(document).on('click', '#BtnLeaveTeam', async () => {
    await user.leaveTeam();
});

$(document).on('click', '#BtnDestroyTeam', async () => {
    await user.destroyTeam();
});
//
class User {
    constructor() {
        this.loadMessages = {
            skipMessages: 0,
            remainingMessages: 0,
        };
    }
    async getModal(event) {
        event.stopPropagation();
        var res = await axios.get($(event.currentTarget).data('route'));
        $('#AppendPosition').append(res.data.modal);
        return;
    }
    async sendMessage() {
        let _content = $('#content').val();
        $('#content').val('');
        if (_content.trim()) {
            var res = await axios.post($('#FormSendMsg').data('route'), {
                content: _content,
                team_id: $('#messages').attr('teamid'),
            });
            if (res.data.error == true) {
                $('#AppendPosition').append(res.data.toast_notice);
                $('#toast').toast('show');
            }
            resetFormMessageData();
        } else return false;
    }
    async replyMessage() {
        let _content = $('#content').val();
        $('#content').val('');
        if (_content.trim()) {
            var res = await axios.post($('#FormSendMsg').data('reproute'), {
                content: _content,
                teamid: $('#messages').attr('teamid'),
                parentid: $('#FormSendMsg').data('parentid'),
            });
            if (res.data.error == true) {
                $('#AppendPosition').append(res.data.toast_notice);
                $('#toast').toast('show');
            }
            $('#BtnReplyMsg').prop('id', 'BtnSendMsg');
            resetFormMessageData();
        } else return false;
    }
    async viewMessageImage(event) {
        var res = await axios.post(`${APP_DOMAIN}/message/get-viewmsgimg-md`, {
            img: $(event.target).attr('src'),
        });
        $('#AppendPosition').append(res.data.view_msg_img);
        $('#ViewMsgImgModal').modal('show');
        resetFormMessageData();
        return;
    }
    async getMemberInfoModal(event) {
        $(event.currentTarget).closest('ul').children('.mem-item-active').removeClass('mem-item-active');
        $(event.currentTarget).addClass('mem-item-active');
        await this.getModal(event);
        $('#ModalMemInfo').modal('show');
        $('#ModalMemInfo').on('hide.bs.modal', e => {
            $(event.currentTarget).removeClass('mem-item-active');
        });
        return;
    }
    async getCreateTeamModal(event) {
        await this.getModal(event);
        $('#ModalCreateTeam').modal('show');
        return;
    }
    async getJoinTeamModal(event) {
        await this.getModal(event);
        $('#ModalJoinTeam').modal('show');
        return;
    }
    async getAddMemModal(event) {
        await this.getModal(event);
        $('#ModalAddMem').modal('show');
        return;
    }
    async getChangeColorModal(event) {
        await this.getModal(event);
        $('#ModalChgColor').modal('show');
        return;
    }
    async getChangeBackgroundModal(event) {
        await this.getModal(event);
        $('#ModalChgBg').modal('show');
        return;
    }
    async getLeaveTeamModal(event) {
        await this.getModal(event);
        $('#ModalLeaveTeam').modal('show');
        return;
    }
    async getDestroyTeamModal(event) {
        await this.getModal(event);
        $('#ModalDestroyTeam').modal('show');
        return;
    }
    async getChangeTeamNameModal(event) {
        await this.getModal(event);
        $('#ModalChangeTeamName').modal('show');
        return;
    }
    async getDestroyMemberModal(event) {
        $(event.currentTarget).closest('ul').children('.mem-item-active').removeClass('mem-item-active');
        $(event.currentTarget).closest('li').addClass('mem-item-active');
        await this.getModal(event);
        $('#ModalDesMem').modal('show');
        $('#ModalDesMem').on('hide.bs.modal', e => {
            $(event.currentTarget).closest('li').removeClass('mem-item-active');
        });
        return;
    }
    async getDestroyMessageModal(event) {
        var res = await axios.get($(event.target).data('route'), {
            params: {
                msgid: $(event.target).closest('li').attr('id')
            }
        });
        $('#AppendPosition').append(res.data.modal);
        $('#ModalDesMsg').data({
            trash: $(event.target),
            reply: $(event.target).prev(),
            msg: $(event.target).closest('li').find('.content')
        })
        $('#ModalDesMsg').modal('show');
        return;
    }
    async changeNickname() {
        var res = await axios.post($('#FormChgNickname').data('route'), {
            nickname: $('#nickname').val(),
            teamid: $('#messages').attr('teamid')
        });
        if (res.data.error == false) {
            $('#RefreshTmMem').click();
            $('#ModalMemInfo').modal('hide');
        } else {
            $('#AppendPosition').append(res.data.toast_notice);
            $('#toast').toast('show');
            $('#nickname').addClass('is-invalid');
        }
        return;
    }
    async createTeam() {
        $('#team_name').removeClass('is-invalid');
        var res = await axios.post($('#FormCreateTeam').data('route'), {
            name: $('#team_name').val(),
        });
        if (res.data.error == false) {
            window.location.replace('/');
        } else {
            $('#AppendPosition').append(res.data.toast_notice);
            $('#toast').toast('show');
            $('#team_name').addClass('is-invalid');
        }
        return;
    }
    async joinTeam() {
        $('#join_code').removeClass('is-invalid');
        var res = await axios.post($('#FormJoinTeam').data('route'), {
            join_code: $('#join_code').val(),
        });
        if (res.data.error == false) {
            window.location.replace('/');
        } else {
            $('#AppendPosition').append(res.data.toast_notice);
            $('#toast').toast('show');
            $('#join_code').addClass('is-invalid');
        }
        return;
    }
    async addMember() {
        $('#addname').removeClass('is-invalid');
        var res = await axios.post($('#FormAddMem').data('route'), {
            name: $('#addname').val(),
        });
        if (res.data.error == false) {
            $('#accordionMember').empty();
            $('#accordionMember').append(res.data.view_team_mems);
            $('#MsgFrame .count-members span').html((index, oldhtml) => {
                return parseInt(oldhtml) + 1;
            });
            $('#ModalAddMem').modal('hide');
        } else {
            $('#AppendPosition').append(res.data.toast_notice);
            $('#toast').toast('show');
            $('#addname').addClass('is-invalid');
        }
        return;
    }
    async viewTeamMessage(event) {
        event.stopPropagation();
        var res = await axios.get($(event.currentTarget).data('route'));
        $('#MsgFrame').children().remove();
        $('#accordionMember').children().remove();
        if (res.data.error == false) {
            $('#MsgFrame').append(res.data.view_msg_frame);
            $('#accordionMember').append(res.data.view_team_mems);
            $('#messages').animate({
                scrollTop: $('#messages')[0].scrollHeight
            }, 800);
            $('[data-toggle="tooltip"]').tooltip();
            $('#content').emoji({
                listCSS: {
                    position: 'absolute',
                    top: 0,
                    left: 0,
                    transform: 'translate(58%, -110%)',
                },
            });
            $(event.currentTarget).closest('ul').children('.team-item-active').removeClass('team-item-active');
            $(event.currentTarget).addClass('team-item-active');
            //unsub old channel
            //if (window.pusherConfig.channelName !== null) window.pusherConfig.pusher.unsubscribe(window.pusherConfig.channelName);
            pusher.unsubscribeCurrentChannel();
            //set channel's name
            //window.pusherConfig.channelName = 'team.' + res.data.teamid;
            pusher.channelName = 'team.' + res.data.teamid;
            //subscribe to a channel
            //window.pusherConfig.channel = window.pusherConfig.pusher.subscribe(window.pusherConfig.channelName);
            pusher.subscribe();
            
            //bind an event listener
            pusher.bindEvent('App\\Events\\NewMessageEvent', function(data) {
                if (data.team_id == $('#messages').attr('teamid')) {
                    let msg_item = data.message_item;
                    if (data.user_id != $('#messages').attr('uid')) {
                        msg_item = msg_item.replace('<i class="fal fa-trash" class="msg-des-modal" data-route="https://hi-mates.com.test/message/get-desmsg-md"></i>', '');
                        msg_item = msg_item.replace('m-dr', 'm-dl');
                    }
                    $('#messages').append(msg_item);
                    $('[data-toggle="tooltip"]').tooltip();
                    if ($('#messages')[0].scrollTop > $('#messages').height() / 2) {
                        $('#messages').stop().animate({
                            scrollTop: $('#messages')[0].scrollHeight
                        }, 800);
                    }
                }
            });
            /**
             * window.pusherConfig.channel.bind('App\\Events\\NewMessageEvent', function(data) {
                if (data.team_id == $('#messages').attr('teamid')) {
                    let msg_item = data.message_item;
                    if (data.user_id != $('#messages').attr('uid')) {
                        msg_item = msg_item.replace('<i class="fal fa-trash" class="msg-des-modal" data-route="https://hi-mates.com.test/message/get-desmsg-md"></i>', '');
                        msg_item = msg_item.replace('m-dr', 'm-dl');
                    }
                    $('#messages').append(msg_item);
                    $('[data-toggle="tooltip"]').tooltip();
                    if ($('#messages')[0].scrollTop > $('#messages').height() / 2) {
                        $('#messages').stop().animate({
                            scrollTop: $('#messages')[0].scrollHeight
                        }, 800);
                    }
                }
            });
             */
            resetFormMessageData();
            this.loadMessages.remainingMessages = res.data.remainingMsg;
            this.loadMessages.skipMessages = 0;
        } else {
            $('#AppendPosition').append(res.data.toast_notice);
            $('#toast').toast('show');
        }
        return;
    }
    async renewJoinCode(event) {
        var res = await axios.get($('#RenewJoinCode').data('route'));
        event.target.previousElementSibling.innerHTML = 'ID nhóm: ' + res.data.newcode;
        return;
    }
    async changeColor() {
        let scrollTop = $('#messages')[0].scrollTop;
        var res = await axios.post($('#form_chgtmcolor').data('route'), {
            color: $('#tm_color').val(),
        });
        $('#ModalChgColor').modal('hide');
        $('#MsgFrame').empty();
        $('#MsgFrame').append(res.data.view_msg_frame);
        $('#messages')[0].scrollTop = scrollTop;
        return;
    }
    async leaveTeam() {
        var res = await axios.post($('#ModalLeaveTeam').data('route'));
        location.reload();
        return;
    }
    async destroyTeam() {
        var res = await axios.post($('#ModalDestroyTeam').data('route'));
        location.reload();
        return;
    }
    async destroyMember() {
        var res = await axios.post($('#ModalDesMem').data('route'));
        $('#accordionMember').empty();
        $('#accordionMember').append(res.data.view_team_mems);
        $('#ModalDesMem').modal('hide');
        return;
    }
    async refreshListTeam() {
        var res = await axios.get($('#RefreshTm').data('route'));
        $('#accordionTeam').remove();
        $('#accordionMember').before(res.data.list_team);
        $('#MsgFrame').children().remove();
        $('#accordionMember').children().remove();
        return;
    }
    async refreshTeamMember() {
        var res = await axios.get($('#RefreshTmMem').data('route'));
        $('#accordionMember').empty();
        $('#accordionMember').append(res.data.view_team_mems);
        return;
    }
    async destroyMessage() {
        await axios.post($('#ModalDesMsg').data('route'));
        $('#ModalDesMsg').data('msg').empty().html('<small><i>Tin nhắn đã xóa</i></small>');
        $('#ModalDesMsg').data('trash').remove();
        $('#ModalDesMsg').data('reply').remove();
        $('#ModalDesMsg').modal('hide');
        return;
    }
    async changeBackground() {
        let file_data = $('#tm_bg').prop('files')[0];
        let form_data = new FormData();
        form_data.append('tm_bg', file_data);

        await axios({
                url: $('#form_chgtmbg').data('route'),
                method: 'POST',
                data: form_data,
                headers: { 'content-type': 'multipart/form-data' }
            })
            .then(res => {
                if (res.data.error == true) {
                    $('#AppendPosition').append(res.data.toast_notice);
                    $('#toast').toast('show');
                } else {
                    $('#ModalChgBg').modal('hide');
                    $('#messages').css("background-image", "url(" + res.data.bgimg + ")");
                }
            })
            .catch(err => {
                console.log(err)
            });
        return;
    }
    async sendImageMessage(event) {
        let file_data = $('#msg_img').prop('files')[0],
            form_data = new FormData();
        form_data.append('msg_img', file_data);
        form_data.append('teamid', $('#messages').attr('teamid'));
        form_data.append('parentid', $('#FormSendMsg').data('parentid'));

        await axios({
                url: $(event.target).data('route'),
                method: 'POST',
                data: form_data,
                headers: { 'content-type': 'multipart/form-data' }
            })
            .then(res => {
                if (res.data.error == true) {
                    $('#AppendPosition').append(res.data.toast_notice);
                    $('#toast').toast('show');
                } else {
                    $('#msg_img').val('');
                    $('#PreviewImg span:last').click();
                }
            })
            .catch(err => {
                console.log(err)
            });
        resetFormMessageData();
        return;
    }
    async sendFileMessage(event) {
        let file_data = $('#msg_file').prop('files')[0],
            form_data = new FormData();
        form_data.append('msg_file', file_data);
        form_data.append('teamid', $('#messages').attr('teamid'));
        form_data.append('parentid', $('#FormSendMsg').data('parentid'));

        await axios({
                url: $(event.target).data('route'),
                method: 'POST',
                data: form_data,
                headers: { 'content-type': 'multipart/form-data' },
            })
            .then(res => {
                if (res.data.error == true) {
                    $('#AppendPosition').append(res.data.toast_notice);
                    $('#toast').toast('show');
                } else {
                    $('#msg_file').val('');
                    $('#PreviewFile span:last').click();
                }
            })
            .catch(err => {
                console.log(err)
            });
        resetFormMessageData();
        return;
    }
    async loadMoreMessages(e) {
        if (e.target.scrollTop == 0) {
            if (this.loadMessages.remainingMessages > 0) {
                this.loadMessages.skipMessages += 20;
                var res = await axios.get(`${APP_DOMAIN}/message/load-more-messages`, {
                    params: {
                        skip: this.loadMessages.skipMessages,
                        team: $('#messages').attr('teamid')
                    }
                });

                if (res.data.error == false) {
                    $('#messages').prepend(res.data.messages);
                    this.loadMessages.remainingMessages = res.data.remainingMsg;
                } else {
                    console.log('error')
                }
            } else {
                if (!document.body.contains(document.getElementById('NoMoreMsg'))) {
                    let li = $('<li id="NoMoreMsg"><p><span>Không còn tin nhắn</span></p></li>');
                    $('#messages').prepend(li);
                }
                return;
            }
        } else return;
    }
    async changeTeamName() {
        var res = await axios.post($('#FormChangeTeamName').data('route'), {
            team_name: $('#team_name').val(),
            teamid: $('#messages').attr('teamid')
        });

        if (res.data.error == true) {
            $('#AppendPosition').append(res.data.toast_notice);
            $('#toast').toast('show');
            $('#team_name').addClass('is-invalid');
        } else {
            let teamname = $('#team_name').val().trim();
            $('.team-item-active').eq(0).attr('title', teamname).find('.tag-item').html(teamname);
            $('#MsgFrame').find('.team-title h4').html(teamname);
            $('#ModalChangeTeamName').modal('hide');
        }
        return;
    }
    async destroyBackground(event) {
        var res = await axios.post($(event.target).data('route'));
        if (res.data.error == true) {
            $('#AppendPosition').append(res.data.toast_notice);
            $('#toast').toast('show');
        } else $('#messages').css("background-image", "url('')");
        return;
    }
}

var user = new User;
NProgress.configure({ showSpinner: false });
