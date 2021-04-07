/**
 * window.pusherConfig = {
    pusher: null,
    channel: null,
    channelName: null,
}

window.pusherConfig.pusher = new Pusher('2d9b74f07a6ead7c49b9', {
    cluster: 'ap1',
    encrypted: true
});
 */
//Pusher.logToConsole = true;

class PusherClient {
    constructor() {
        this.pusherConfig = {
            pusher: null,
            channel: null,
            channelName: null,
            appKey: null,
            cluster: 'ap1',
            encrypted: true
        }
    }

    set channelName(channelName) {
    	this.pusherConfig.channelName = channelName;
    }

    get channelName() {
    	return this.pusherConfig.channelName;
    }

    set appKey(appKey) {
    	this.pusherConfig.appKey = appKey;
    }

    get appKey() {
    	return this.pusherConfig.appKey;
    }

    /**
     * set cluster(cluster) {
    	this.pusherConfig.cluster = cluster;
    }
     */

    get cluster() {
    	return this.pusherConfig.cluster;
    }

    /**
     * set encrypted(bool) {
    	this.pusherConfig.encrypted = bool;
    }
     */

    get encrypted() {
    	return this.pusherConfig.encrypted;
    }

    set pusher(pusher) {
    	this.pusherConfig.pusher = pusher;
    }

    get pusher() {
    	return this.pusherConfig.pusher;
    }

    set channel(channel) {
    	this.pusherConfig.channel = channel;
    }

    get channel() {
    	return this.pusherConfig.channel;
    }

    openConnection() {
        return this.pusher = new Pusher(this.appKey, {
            cluster: this.cluster,
            encrypted: this.encrypted
        });
    }

    subscribe() {
        return this.channel = this.pusher.subscribe(this.channelName);
    }

    unsubscribeCurrentChannel() {
        return this.channelName !== null ? this.pusher.unsubscribe(this.channelName) : false;
    }

    bindEvent(eventName, callback) {
        return this.channel.bind(eventName, callback);
    }

    unbindEvent(eventName=null, callback=null) {
    	return this.channel.unbind(eventName, callback);
    }
}

var pusher = new PusherClient;
pusher.appKey = '2d9b74f07a6ead7c49b9';
pusher.openConnection();
