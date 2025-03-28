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
    public static function authenticate(array $credentials): array
    {
        return Auth::attempt($credentials);
    }
}
