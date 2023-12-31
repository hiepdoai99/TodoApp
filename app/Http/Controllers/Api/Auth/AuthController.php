<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Mail;
use GuzzleHttp;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        return $this->respondWithToken($request->authenticate());
    }

    protected function respondWithToken($token)
    {
        $user = auth()->user();

        if ($user->is_email_verified != 1){

            $token = Str::random(10);
            UserVerify::create([
                'user_id' => $user->id,
                'token' => $token
            ]);

            Mail::send('emails.index', ['token' => $token, 'user' => $user], function($message) use($user){
                $message->to($user->email);
                $message->subject('Email Verification Mail');
            });
            return response()->json([
                'message' => 'Unconfirmed email. Please verify your email',
                'status'=> 201,
            ]);
        }
        $this->discord();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 480,
            'user'=>$user,
        ]);
    }
    public function verifyToken(Request $request)
    {
        if ($request->token) {
            try {
                return auth()->user();
            } catch (\Exception $e) {
                return $this->respondUnAuthenticated($e->getMessage());
            }
        }
        return $this->respondFailedValidation(__('validation.required', ['attribute', 'Token']));
    }
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    public function discord(){
        $client = new \GuzzleHttp\Client();

        $webhookUrl = 'https://discord.com/api/webhooks/1153956046046511104/Qm6iTt53NsWDrzVDkOGZyHGobOhbTidPj3A4PaNqqq6iz54i3g03PnuJdM5ucg2cJXh0';
        $user = auth()->user();
        $data = [
            'content' => $user->name .'➡️ **Vừa đăng nhập** ',
        ];

        $response = $client->post( $webhookUrl, [
            'json' => $data,
        ]);

        return $response;
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */

}
