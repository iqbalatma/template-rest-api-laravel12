<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthenticateRequest;
use App\Services\Auth\AuthenticateService;
use Iqbalatma\LaravelUtils\APIResponse;

class AuthenticateController extends Controller
{
    public function __construct()
    {
        $this->responseMessages = [
            "authenticate" => "Authenticate successfully.",
        ];
    }

    /**
     * @param AuthenticateRequest $request
     * @return APIResponse
     */
    public function authenticate(AuthenticateRequest $request): APIResponse
    {
        return new APIResponse(
            AuthenticateService::attempt(),
            $this->getResponseMessage(__FUNCTION__),
        );
    }
}
