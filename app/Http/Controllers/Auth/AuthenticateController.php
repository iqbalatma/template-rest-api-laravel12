<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthenticateRequest;
use App\Http\Resources\Auth\AuthenticateResource;
use App\Http\ResponseCode;
use App\Services\Auth\AuthenticateService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Fluent;
use Iqbalatma\LaravelJwtAuthentication\Exceptions\JWTInvalidActionException;
use Iqbalatma\LaravelJwtAuthentication\Exceptions\JWTUnauthenticatedUserException;
use Iqbalatma\LaravelJwtAuthentication\Services\IssuedTokenService;
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
        ])->withCookie(getCreatedCookie($response["tokens"]["refresh_token"]));
    }

    /**
     * @return APIResponse
     */
    public function logout(): APIResponse
    {
        Auth::logout();
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
        ])->withCookie(getCreatedCookie($response["tokens"]["refresh_token"]));
    }
}
