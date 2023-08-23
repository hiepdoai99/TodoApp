<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserTeamCollection;
use App\Jobs\SendMailInvite;
use App\Models\User;
use App\Models\UserTeam;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mail;
use Spatie\QueryBuilder\QueryBuilder;

class InviteTeamController extends Controller
{

    public function getTeam(Request $request){
        $user = Auth::user();
        $allTeams = [];
        $teams = $user->teams;
        foreach ($teams as $team){
            $allTeams[] = [
                'id' => $team->id,
                'name' => $team->name,
            ];
        }
        return response()->json($allTeams);
    }

    public function invite(Request $request)
    {
        $a = Auth::user();
        $team = $request->team_id;

        if ($a->teams){
            if ($request->id){
                $token = Str::random(10);
                $user = User::find($request->id);
                UserVerify::create([
                    'user_id' => $user->id,
                    'token' => $token
                ]);
                SendMailInvite::dispatch($user,$token,$team);
            }else{
                $email = $request->email;

                Mail::send('emails.inviteRegister',['email'=>$email,'team'=>$team], function ($message) use ($email) {
                    $message->to($email);
                    $message->subject('Email Invite Team');
                });
            }
        }

    }

    public function verify($id,$token)
    {
        $a = Auth::user();
        $verifyUser = UserVerify::with('user')->where('token', $token)->first();
        $message = 'verified fail';
        if (!is_null($verifyUser)) {
            $user = $verifyUser->user;
                UserTeam::create([
                'team_id'=>$id,
                'user_id'=>$user->id
            ]);
                $message = "success";

        }
        return response()->json ([
            'done' => isset($verifyUser),
            'message'  => $message
        ]);
    }
}
