<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthenticateRequest;
use App\Http\Resources\Auth\AuthenticateResource;
use App\Services\Auth\AuthenticateService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
     * @return APIResponse
     * @throws JWTUnauthenticatedUserException
     */
    public function authenticate(AuthenticateRequest $request): APIResponse
    {
        return new APIResponse(
            new AuthenticateResource(AuthenticateService::authenticate($request->validated())),
            $this->getResponseMessage(__FUNCTION__),
        );
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
     * @return APIResponse
     */
    public function refresh(): APIResponse
    {
        $user = Auth::user();
        $tokens = Auth::refreshToken($user);
        return new APIResponse(
            new AuthenticateResource([
                "user" => $user,
                "tokens" => $tokens
            ]),
            $this->getResponseMessage(__FUNCTION__),
        );
    }
}
