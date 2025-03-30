<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Fluent;
use Iqbalatma\LaravelJwtAuthentication\Exceptions\JWTUnauthenticatedUserException;
use Iqbalatma\LaravelServiceRepo\Attributes\ServiceRepository;
use Iqbalatma\LaravelServiceRepo\BaseService;

#[ServiceRepository(UserRepository::class)]
class AuthenticateService extends BaseService
{
    /**
     * @param array $credentials
     * @return array
     * @throws JWTUnauthenticatedUserException
     */
    public static function authenticate(array $credentials): array
    {
        if (!($token = Auth::attempt($credentials))) {
            throw new JWTUnauthenticatedUserException("Invalid credentials");
        }

        return [
            "user" => Auth::user(),
            "tokens" => (array) $token
        ];
    }
}
