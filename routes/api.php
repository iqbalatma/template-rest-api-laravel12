<?php

use App\Http\Controllers\Auth\AuthenticateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix("auth")
    ->name("auth.")
    ->controller(AuthenticateController::class)->group(function () {
        Route::post("authenticate", "authenticate");
        Route::post("logout", "logout")->middleware("auth.jwt:" . \Iqbalatma\LaravelJwtAuthentication\Enums\JWTTokenType::ACCESS->name);
        Route::post("refresh", "refresh")->middleware("auth.jwt:" . \Iqbalatma\LaravelJwtAuthentication\Enums\JWTTokenType::REFRESH->name);
    });


Route::middleware("auth.jwt:" . \Iqbalatma\LaravelJwtAuthentication\Enums\JWTTokenType::ACCESS->name)->group(function () {
    Route::prefix("master")->name("master")->group(function () {
        Route::controller(\App\Http\Controllers\Master\AuthorizationController::class)->group(function () {
            Route::get("roles", "roles")->name("roles");
            Route::get("permissions", "permissions")->name("permissions");
        });
    });


    Route::prefix("management")->name("management")->group(function () {
        Route::prefix("roles")->name("roles.")->controller(\App\Http\Controllers\Management\RoleController::class)->group(function () {
            Route::get("", "index")->name("index")->middleware("permission:" . \App\Enums\Permission::MANAGEMENT_ROLE_SHOW->value);
        });
    });
});
