<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\RegisterAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\UserVerify;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        if ($user = app(RegisterAction::class)->execute($request->all())) {
            return $this->respondCreated(new UserResource($user));
        }
        return $this->respondError('Tao moi user that bai');
    }

    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::with('user')->where('token', $token)->first();
        $message = 'Your e-mail is verified fail';
        if (!is_null($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }

        return response()->json ([
            'done' => isset($verifyUser),
            'message'  => $message
        ]);
    }
}
