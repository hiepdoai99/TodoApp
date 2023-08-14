<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailInvite;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mail;

class InviteTeamController extends Controller
{
    public function invite(Request $request)
    {
        $a = Auth::user();
        $team = $a->team_id ?? null;

        if ($a->team_id){
            if ($request->id){
                $token = Str::random(10);
                $user = User::find($request->id);
                UserVerify::create([
                    'user_id' => $user->id,
                    'token' => $token
                ]);
                SendMailInvite::dispatch($user,$token);
            }else{
                $email = $request->email;

                Mail::send('emails.inviteRegister',['email'=>$email,'team'=>$team], function ($message) use ($email) {
                    $message->to($email);
                    $message->subject('Email Invite Team');
                });
            }
        }

    }

    public function verify($token)
    {
        $team = Auth::user();
        $verifyUser = UserVerify::with('user')->where('token', $token)->first();
        $message = 'verified fail';
        if (!is_null($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->team_id) {
                $verifyUser->user->team_id = $team->team_id;
                $verifyUser->user->save();
                $message = "success";
            } else {
                $message = "fail";
            }
        }
        return response()->json ([
            'done' => isset($verifyUser),
            'message'  => $message
        ]);
    }
}
