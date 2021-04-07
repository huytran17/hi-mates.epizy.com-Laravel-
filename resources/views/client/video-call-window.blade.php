<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Call</title>
    <script src="https://cdn.jsdelivr.net/npm/axios@0.20.0/dist/axios.min.js"></script>
    <script src="https://cdn.stringee.com/sdk/web/2.2.1/stringee-web-sdk.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <!-- <script src="{{ asset('js/pusher.js') }}" charset="utf-8" defer></script> -->
    <script src="{{ asset('js/api.js') }}" charset="utf-8" defer></script>
    <script src="{{ asset('js/stringee.js') }}" charset="utf-8" defer></script>
    <style rel="stylesheet">
        #BtnCreateMeeting, #BtnShareScreen {
            padding: 8px;
            color: white;
            margin: 1rem .5rem;
            border: none;
            border-radius: 3px;
        }
        #BtnCreateMeeting {
            background-color: rgb(31, 156, 224);
        }
        #BtnShareScreen {
            background-color: rgb(6, 209, 161);
        }
        #BtnWrapper {
            display: flex;
            justify-content: center;
        }
        .info {
            margin-left: 1rem;
        }
        .container {
          padding-top: 1rem;
        }

        #videos {
          display: flex;
          flex-wrap: wrap;
          margin-top: 20px;
        }

        #videos video {
          flex: 1 1 50%;
          padding: 0;
          min-width: 0;
        }
    </style>
</head>

<body>
    <div id="BtnWrapper">
        <button class="button is-primary" onclick="createRoom()" id="BtnCreateMeeting">
            Bắt đầu trò chuyện
        </button>
        <!--
            <button class="button is-info" onclick="joinWithId()">
            Join Meeting
        </button>
        -->
        <button class="button is-info" onclick="publish(true)" id="BtnShareScreen">
            Chia sẻ màn hình
        </button>
    </div>
    <div class="info">
        <p><strong>Room URL: </strong><i></i></p>
    </div>
    <div class="container">
        <div id="videos"></div>
    </div>
</body>
</html>
