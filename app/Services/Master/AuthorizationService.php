<?php

namespace App\Services\Master;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Collection;
use Iqbalatma\LaravelServiceRepo\BaseService;

class AuthorizationService extends BaseService
{
    /**
     * @return Collection
     */
    public static function getAllRoles(): Collection
    {
        return Role::all();
    }

    /**
     * @return Collection
     */
    public static function getAllPermissions(): Collection
    {
        return Permission::all();
    }
}
