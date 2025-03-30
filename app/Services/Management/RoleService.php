<?php

namespace App\Services\Management;

use App\Models\Role;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Iqbalatma\LaravelServiceRepo\BaseService;

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
