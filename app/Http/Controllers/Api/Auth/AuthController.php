<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        return $this->respondWithToken($request->authenticate());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 3660
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

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */

}
