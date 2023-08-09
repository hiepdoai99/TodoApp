<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailInvite;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InviteTeamController extends Controller
{
    public function invite(Request $request)
    {
        $a = Auth::user();

        if ($a->team_id){
            $token = Str::random(10);
            $user = User::find($request->id);
            UserVerify::create([
                'user_id' => $user->id,
                'token' => $token
            ]);
            SendMailInvite::dispatch($user,$token);
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
