var URL = window.URL || window.webkitURL;
var gumStream,
    rec,
    input,
    AudioContext = window.AudioContext || window.webkitAudioContext,
    audioContext = new AudioContext;

$(document).on('click', '#Record', startRecord);

function startRecord(event) {
    $(event.target).removeClass('fa-headset').addClass('spinner-grow text-primary');
    var constraints = {
        audio: true,
        video: false
    }

    $(document).off('click', '#Record', startRecord);
    $(document).on('click', '#Record', stopRecord);

    navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
        gumStream = stream;
        input = audioContext.createMediaStreamSource(stream);
        rec = new Recorder(input, {
            numChannels: 1
        })
        rec.record();
        //$(document).on('click', '#PauseRecord', pauseRecord);
        //$(document).on('click', '#StopRecord', stopRecord);
    }).catch(function(err) {
        $(document).on('click', '#Record', startRecord);
    });
}

/**
 * function pauseRecord(event) {
    if (rec.recording) {
        rec.stop();
        $('#PauseRecord').removeClass('fa-pause-circle').addClass('fa-play-circle');
        $('#StartRecord').removeClass('spinner-grow text-primary').addClass('fa-circle');
    } else {
        rec.record()
        $('#PauseRecord').removeClass('fa-play-circle').addClass('fa-pause-circle');
        $('#StartRecord').removeClass('fa-circle').addClass('spinner-grow text-primary');
    }
}
 */

//function createDownloadLink(blob) {
    /**
     * let url = URL.createObjectURL(blob),
        au = document.createElement('audio');

    au.controls = true;
    au.src = url;
    au.type = 'audio/wav';
     * @type {[type]}
     */
    //aublob = blob;
    //$('#PreviewRecord').prepend(au);
    //$('#PreviewRecord').toggle();
//}

function stopRecord(event) {
    //$(document).off('click', '#PauseRecord', pauseRecord);
    $(document).off('click', '#Record', stopRecord);
    $(document).on('click', '#Record', startRecord);
    $('#Record').removeClass('spinner-grow text-primary').addClass('fa-headset');

    rec.stop();
    gumStream.getAudioTracks()[0].stop();
    rec.exportWAV(async blob => {
        var fd = new FormData();
        let filename = new Date().toISOString();
        fd.append('teamid', $('#messages').attr('teamid'));
        fd.append('parentid', $('#FormSendMsg').data('parentid'));
        fd.append("audio_data", blob, filename);

        await axios({
                url: $(this).data('route'),
                method: 'POST',
                data: fd,
                headers: { 'Content-Type': 'multipart/form-data' }
            })
            .then(res => {
                if (res.data.error == true) {
                    $('#AppendPosition').append(res.data.toast_notice);
                    $('#toast').toast('show');
                }
            })
            .catch(err => {
                console.log(err)
            });
    });
}

/**
 * $(document).on('click', '#PreviewRecord span:first', async function(event) {
    var fd = new FormData();
    let filename = new Date().toISOString();
    fd.append('teamid', $('#messages').attr('teamid'));
    fd.append('parentid', $('#FormSendMsg').data('parentid'));
    fd.append("audio_data", aublob, filename);

    await axios({
            url: $(this).attr('data-route'),
            method: 'POST',
            data: fd,
            headers: { 'Content-Type': 'multipart/form-data' }
        })
        .then(res => {
            if (res.data.error == true) {
                $('#AppendPosition').append(res.data.toast_notice);
                $('#toast').toast('show');
            } else {
                $('#PreviewRecord span:last').click();
            }
        })
        .catch(err => {
            console.log(err)
        });
});
 */

/**
 * $(document).on('click', '#PreviewRecord span:last', function(event) {
    $('#PreviewRecord audio').remove();
    $('#PreviewRecord').toggle();
    resetFormMessageData();

    $(document).on('click', '#StartRecord', startRecord);

    $('#PauseRecord').removeClass('fa-play-circle').addClass('fa-pause-circle');
});

$(document).on('click', '#VoiceBtn', function(event) {
    $('.record-btn').toggle();
});
 */
