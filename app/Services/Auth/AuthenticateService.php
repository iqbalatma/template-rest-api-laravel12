<?php

namespace App\Services\Auth;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Iqbalatma\LaravelServiceRepo\Attributes\ServiceRepository;
use Iqbalatma\LaravelServiceRepo\BaseService;

#[ServiceRepository(UserRepository::class)]
class AuthenticateService extends BaseService
{
    public static function attempt(array $credentials): User
    {
        ddapi(Auth::attempt($credentials));
    }
}
