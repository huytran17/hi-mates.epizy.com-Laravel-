const videoContainer = $("#videos");
const APP_DOMAIN = "https://hi-mates.com.test";

class Caller {
    constructor() {
        this.userToken = '';
        this.roomId = '';
        this.roomToken = '';
        this.room = '';
        this.callClient = '';
        this.teamId = '';
    }

    authen() {
        return new Promise(async resolve => {
            const userId = `${(Math.random() * 100000).toFixed(6)}`;
            const userToken = await api.getUserToken(userId);
            this.userToken = userToken;

            if (!this.callClient) {
                const client = new StringeeClient();

                client.on("authen", function(res) {
                    //console.log("on authen: ", res);
                    resolve(res);
                });
                this.callClient = client;
            }
            this.callClient.connect(userToken);
        });
    }
    async publish(screenSharing = false) {
        const localTrack = await StringeeVideo.createLocalVideoTrack(
            this.callClient, {
                audio: true,
                video: true,
                screen: screenSharing,
                videoDimensions: { width: 640, height: 360 }
            }
        );

        const videoElement = localTrack.attach();
        this.addVideo(videoElement);

        const roomData = await StringeeVideo.joinRoom(
            this.callClient,
            this.roomToken
        );
        const room = roomData.room;
        //console.log({ roomData, room });

        if (!this.room) {
            this.room = room;
            room.clearAllOnMethos();
            room.on("addtrack", e => {
                const track = e.info.track;

                //console.log("addtrack", track);
                if (track.serverId === localTrack.serverId) {
                    //console.log("local");
                    return;
                }
                this.subscribe(track);
            });
            room.on("removetrack", e => {
                console.log('remove track')
                const track = e.track;
                if (!track) {
                    return;
                }

                const mediaElements = track.detach();
                mediaElements.forEach(element => element.remove());
            });

            // Join existing tracks
            roomData.listTracksInfo.forEach(info => this.subscribe(info));
        }

        await room.publish(localTrack);
        //console.log("room publish successful");
    }
    async createRoom() {
        const room = await api.createRoom();
        const { roomId } = room;
        const roomToken = await api.getRoomToken(roomId);

        this.roomId = roomId;
        this.roomToken = roomToken;
        //console.log({ roomId, roomToken });

        await this.authen();
        await this.publish();
        await this.notification();
        //await this.dispatchNotification();

        this.setRooomUrl();
    }

    async join() {
        if (await this.checkUserInTeam() === true) {
            const roomToken = await api.getRoomToken(this.roomId);
            this.roomToken = roomToken;

            await this.authen();
            await this.publish();
        }

    }

    /**
     * async joinWithId() {
        const roomId = prompt("Dán Room ID vào đây nhé!");
        if (roomId) {
            this.roomId = roomId;
            await this.join();
        }
    }
     */

    async subscribe(trackInfo) {
        const track = await this.room.subscribe(trackInfo.serverId);
        track.on("ready", () => {
            const videoElement = track.attach();
            this.addVideo(videoElement);
        });
    }

    async notification() {
        await axios.post(`${APP_DOMAIN}/message/store`, {
                team_id: this.teamId,
                content: `Đã bắt đầu trò chuyện: <a href="${this.roomUrl()}" target="_blank">Tham gia ngay</a>`,
            })
            .then(response => {
                console.log(response)
            })
            .catch(error => {
                console.log(error)
            });
    }

    async checkUserInTeam() {
        var isvalid = false;
        await axios.post(`${APP_DOMAIN}/check-user-in-team`, {
                teamid: this.teamId,
            })
            .then(res => {
                console.log(res.data.error)
                if (res.data.error == false) isvalid = true;
                else {
                    document.write('Bạn không ở trong nhóm này')
                }
            })
            .catch(error => {
                console.log(error)
            });
        return isvalid;
    }

    setRooomUrl() {
        $('.info p:last i').html(this.roomUrl());
    }

    addVideo(video) {
        video.setAttribute("controls", "true");
        video.setAttribute("playsinline", "true");
        videoContainer.append(video);
    }

    roomUrl() {
        return `https://${location.hostname}/call?team=${this.teamId}&room=${this.roomId}`;
    }

    /**
     * async dispatchNotification() {
        var res = await axios.post(APP_DOMAIN + '/message/dispatch-notifi', {
            team_id: this.teamId,
        });
    }
     */
}

var caller = new Caller;

function createRoom() {
    caller.createRoom();
}

/**
 * function joinWithId() {
    caller.joinWithId();
}
 */

function publish(screenSharing) {
    caller.publish(screenSharing);
}

window.addEventListener('DOMContentLoaded', async (event) => {
    api.setRestToken();

    const urlParams = new URLSearchParams(location.search);
    const roomId = urlParams.get("room");
    caller.teamId = urlParams.get('team');

    if (roomId) {
        caller.roomId = roomId;
        $('#BtnCreateMeeting').remove();
        await caller.join();
    }

    /**
     * pusher.unsubscribeCurrentChannel();
    pusher.channelName = 'groupcall.' + caller.teamId;
    pusher.subscribe();
    pusher.unbindEvent();
    pusher.bindEvent('App\\Events\\GroupCallEvent', function(data) {
        console.log('new event')
        console.log(data)
    });
     */
});
