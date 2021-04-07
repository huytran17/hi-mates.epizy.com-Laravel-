<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Carbon;
use App\Http\Requests\MessageStoreImageRequest;
use App\Http\Requests\MessageStoreDocumentRequest;
use App\Http\Requests\MessageStoreAudioRequest;
use App\Services\UploadFileService;
use App\Events\NewMessageEvent;
use App\Events\GroupCallEvent;
use App\Models\Message;
use App\Models\TeamUser;
use App\Models\Team;

class MessageController extends Controller
{
    protected $user, $team, $teamuser, $uploadFileService;

    public function __construct(Message $message, Team $team, TeamUser $teamuser, UploadFileService $uploadFileService)
    {
        $this->message = $message;

        $this->team = $team;

        $this->teamuser = $teamuser;    

        $this->uploadFileService = $uploadFileService;
    }

    public function store(Request $rq)
    {
        return $this->dispatchNewMessage($rq->team_id, trim($rq->content), null);
    }

    public function reply(Request $rq)
    {
        return $this->dispatchNewMessage($rq->teamid, trim($rq->content), base64_decode($rq->parentid));
    }

    public function destroy(Request $rq)
    {
        return $this->message->destroyMessage(base64_decode($rq->msgid));
    }

    public function getDestroyMsgModal(Request $rq)
    {
        return $this->getViewResponse('modal', 'client.modal-destroy-msg', false, ['msgid' => $rq->msgid]);
    }

    public function storeImg(MessageStoreImageRequest $rq)
    {
        $img = $this->uploadFileService->getBase64Image($rq->file('msg_img'));

        return $this->dispatchNewMessage($rq->teamid, $img, base64_decode($rq->parentid));
    }

    public function storeDoc(MessageStoreDocumentRequest $rq)
    {
        $file = $this->uploadFileService->getBase64File($rq->file('msg_file'));

        return $this->dispatchNewMessage($rq->teamid, $file, base64_decode($rq->parentid));
    }

    public function storeAudio(MessageStoreAudioRequest $rq)
    {
        $audio = $this->uploadFileService->getBase64Audio($rq->file('audio_data'));

        return $this->dispatchNewMessage($rq->teamid, $audio, base64_decode($rq->parentid));
    }

    public function call(Request $rq)
    {
        return view('client.video-call-window');
    }

    public function checkUserInTeam(Request $rq)
    {
        if (auth()->user() && $this->teamuser->isExists(auth()->id(), base64_decode($rq->teamid))) 
            return response()->axios([
                'error' => false,
            ]);
        return response()->axios([
            'error' => true,
        ]);
    }

    public function getViewMsgImgModal(Request $rq)
    {
        return $this->getViewResponse('view_msg_img', 'client.modal-view-msg-img', false, ['img' => $rq->img]);
    }

    public function loadMoreMessage(Request $rq)
    {
        $skip = $rq->skip;
        $teamid = base64_decode($rq->team);
        try {
            $team = $this->team->getByIdWithException($teamid);
            //$messages = Message::where('team_id', $teamid)->latest()->getLimitMessages($skip, 20)->with(['user', 'team', 'parent'])->get()->toArray();
            $messages = $this->message->getByTeamId($teamid)->latest()->getLimitMessages($skip, 20)->get()->toArray();
            return response()->axios([
                'error' => false,
                'messages' => View::make('client.load-more-messages', [
                                    'messages' => $messages,
                                    'team' => $team
                                ])->render(),
                'remainingMsg' => $team->allMessages->count() - $skip - 20,
            ]);
        }
        catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }

        return response()->axios([
            'error' => true,
        ]);
    }

    public function dispatchNewMessage($teamid, $content, $parentid=null)
    {
        $d_teamid = base64_decode($teamid);

         if ($this->teamuser->isExists(auth()->id(), $d_teamid)) {
            if (!empty($content)) {
                if (!$parentid) { //send new
                    $message = $this->message->createMessage([
                        'content' => $content,
                        'team_id' => $d_teamid,
                        'user_id' => auth()->id(),
                    ]);
                }
                else { //send reply
                    $message = $this->message->createMessage([
                        'content' => $content,
                        'team_id' => $d_teamid,
                        'user_id' => auth()->id(),
                        'parent_id' => $parentid,
                    ]);
                }
                $message = $this->message->getById($message->id);

                $message_item = View::make('client.message-item', [
                        'msg' => $message,
                        'team' => $message->team
                    ])->render();

                event(new NewMessageEvent($teamid, auth()->user()->encrypted_id, $message_item));

                return response()->axios([
                    'error' => false
                ]);
            }
        }
        else return $this->getViewResponse('toast_notice', 'client.toast', false,  ['content' => 'Bạn không còn trong nhóm này']);
    }

    public function dispatchNotification(Request $rq)
    {
        event(new GroupCallEvent(base64_decode($rq->team_id)));

        return response()->axios([
            'error' => false
        ]);
    }
}