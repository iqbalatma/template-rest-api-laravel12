<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Services\Management\RoleService;
use Illuminate\Http\Request;
use Iqbalatma\LaravelUtils\APIResponse;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->responseMessages = [
            "index" => "Get all permissions successfully",
        ];
    }

    /**
     * @return APIResponse
     */
    public function index(): APIResponse
    {
        return new APIResponse(
            RoleService::getAllCachedData(),
            $this->getResponseMessage(__FUNCTION__)
        );
    }
}
