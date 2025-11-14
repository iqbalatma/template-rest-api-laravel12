<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthenticateRequest;
use App\Http\Resources\Auth\AuthenticateResource;
use App\Http\ResponseCode;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Iqbalatma\LaravelJwtAuthentication\Exceptions\JWTUnauthenticatedUserException;
use Iqbalatma\LaravelUtils\APIResponse;

class AuthenticateController extends Controller
{
    public function __construct()
    {
        $this->responseMessages = [
            "authenticate" => "Authenticate successfully.",
            "logout" => "Logout successfully.",
            "refresh" => "Refresh successfully.",
        ];
    }

    /**
     * @param AuthenticateRequest $request
     * @return JsonResponse
     * @throws JWTUnauthenticatedUserException
     */
    public function authenticate(AuthenticateRequest $request): JsonResponse
    {
        if (!($tokens = Auth::attempt($request->validated()))) {
            throw new JWTUnauthenticatedUserException("Invalid credentials");
        }

        $response = [
            "user" => Auth::user(),
            "tokens" => (array)$tokens
        ];

        return response()->json([
            "code" => ResponseCode::SUCCESS()->name,
            "message" => $this->getResponseMessage(__FUNCTION__),
            "timestamp" => Carbon::now(),
            "payload" => [
                "data" => new AuthenticateResource($response),
            ],
        ])
            ->withCookie(getCreatedCookieAccessTokenVerifier(Auth::getAccessTokenVerifier()))
            ->withCookie(getCreatedCookieRefreshToken(Auth::getRefreshToken()));

    }

    /**
     * @return APIResponse
     */
    public function logout(): APIResponse
    {
        Auth::logout(true);
        return new APIResponse(
            null,
            $this->getResponseMessage(__FUNCTION__),
        );
    }

    /**
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        $user = Auth::user();
        $tokens = Auth::refreshToken($user);

        $response = [
            "user" => $user,
            "tokens" => $tokens
        ];


        return response()->json([
            "code" => ResponseCode::SUCCESS()->name,
            "message" => $this->getResponseMessage(__FUNCTION__),
            "timestamp" => Carbon::now(),
            "payload" => [
                "data" => new AuthenticateResource($response),
            ],
        ])  ->withCookie(getCreatedCookieAccessTokenVerifier(Auth::getAccessTokenVerifier()))
            ->withCookie(getCreatedCookieRefreshToken(Auth::getRefreshToken()));
    }
}
