<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class TokenController extends Controller
{
    /**
     * Handle an authentication attempt
     *
     * @param \Illuminate\Http\Request $request
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('document_number', 'password');

        if ($token = auth()->guard('api')->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(
            [
                'error' => 'Unauthorized'
            ],
            Response::HTTP_UNAUTHORIZED
        );
    }

    /**
     * Handle an register
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $user = User::create([
            'document_number' => $request->document_number,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'api_token' => Str::random(60),
        ]);

        $token = JWTAuth::fromUser($user);

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->guard('api')->user());
    }

    /**
     * Format and send token
     *
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    private function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->guard('api')->factory()->getTTL() * 60
        ]);
    }
}
