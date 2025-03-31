<?php

namespace App\Services\Management;

use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Iqbalatma\LaravelServiceRepo\Attributes\ServiceRepository;
use Iqbalatma\LaravelServiceRepo\BaseService;

#[ServiceRepository(RoleRepository::class)]
class RoleService extends BaseService
{
    /**
     * @return Collection
     */
    public static function getAllCachedData(): Collection
    {
        $key = config('cache.keys.all_roles');
        if (!($roles = Cache::get($key))) {
            $roles = Role::query()->get();
            Cache::put($key, $roles);
        }
        return $roles;
    }
}
