<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserUpdateInfoRequest;
use App\Http\Requests\UserUpdatePwdRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateAvatarRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\EmailResetPasswordRequest;
use App\Services\UploadFileService;
use App\Mail\ResetPasswordEmail;
use Carbon\Carbon;
use Mail;

class UserController extends Controller
{
    protected $uploadFileService, $user;

    public function __construct(User $user, UploadFileService $uploadFileService, PasswordReset $pwdreset)
    {
        $this->uploadFileService = $uploadFileService;
        
        $this->user = $user;

        $this->pwdreset = $pwdreset;
    }
    
    protected function register(UserRegisterRequest $rq)
    {
        return $this->user->register($rq->all());
    }

    public function login(Request $rq)
    {
        return $this->user->login($rq->only('name', 'password'));
    }

    public function getMemberInfoModal(Request $rq)
    {
        $user = $this->user->getByTeamId(base64_decode($rq->id), base64_decode($rq->teamID));

        return $this->getViewResponse('modal', 'client.modal-mem-info', false, ['member' => $user]);
    }

    public function show(Request $rq)
    {
        return view('client.user-profile', ['user' => json_encode(auth()->user())]);
    }

    public function updateAvatar(UserUpdateAvatarRequest $rq)
    {
        $img = $this->uploadFileService->getBase64Image($rq->file('u_avt'));

        $this->user->updateUser(['profile_photo_path' => $img]);

        return $this->back();
    }

    public function updatePwd(UserUpdatePwdRequest $rq)
    {
        $this->user->updateUser(['password' => $this->makeHash($rq->u_npwd)]);

        return $this->back();
    }

    public function updateInfo(UserUpdateInfoRequest $rq)
    {
        $this->user->updateUser(['name' => $rq->name]);
        
        return $this->back();
    }

    public function destroyAvatar(Request $rq)
    {
        $this->user->updateUser(['profile_photo_path' => null]);

        return $this->back();
    }

    public function back()
    {
        return redirect()->back();
    }

    public function forgotPassword(Request $rq)
    {
        return view('auth.email');
    }

    public function passwordEmail(EmailResetPasswordRequest $rq)
    {
        $token = Str::random(20);

        $this->pwdreset->createPasswordReset(['email' => $rq->email, 'token' => $token]);

        $this->sendMailToUser($rq->email, $token);

        return view('email.verify');
    }

    public function sendMailToUser($email, $token)
    {
        Mail::to($email, $token)->send(new ResetPasswordEmail($token));
    }

    public function resetPasswordForm(Request $rq, $token)
    {
        $pr = $this->pwdreset->getByToken($token);

        if ($this->checkPast($pr->updated_at, 720)) {
            $pr->delete();
            return 'Yêu cầu đã hết hạn';
        }

        return view('auth.reset-password')->with('token', $token);
    }

    public function resendResetPasswordEmail(Request $rq)
    {
        return $this->forgotPassword($rq);
    }

    public function resetPassword(ResetPasswordRequest $rq, $token)
    {
        $pr = $this->pwdreset->getByToken($token);

        $user = $this->user->getByEmail($pr->email)->firstOrFail();

        $user->updatePwd([
            'password' => Hash::make($rq->password),
        ]);

        $pr->delete();

        return redirect()->route('login');
    }

    public function checkPast($time, $minute)
    {
        return Carbon::parse($time)->addMinutes($minute)->isPast();
    }
}
