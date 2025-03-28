<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthenticateRequest;
use App\Services\Auth\AuthenticateService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Iqbalatma\LaravelJwtAuthentication\Exceptions\JWTInvalidActionException;
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
            "user" => "Get user successfully.",
        ];
    }

    /**
     * @param AuthenticateRequest $request
     * @return APIResponse
     */
    public function authenticate(AuthenticateRequest $request): APIResponse
    {
        return new APIResponse(
            AuthenticateService::authenticate($request->validated()),
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
        return new APIResponse(
            Auth::refreshToken(Auth::user()),
            $this->getResponseMessage(__FUNCTION__),
        );
    }



    public function user(): APIResponse
    {
        return new APIResponse([Auth::user(), IssuedTokenService::getAllToken(Auth::id())], $this->getResponseMessage(__FUNCTION__));
    }
}
