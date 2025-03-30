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

Route::prefix("master")->name("master")->group(function () {
    Route::controller(\App\Http\Controllers\Master\AuthorizationController::class)->group(function () {
        Route::get("roles", "roles")->name("roles");
        Route::get("permissions", "permissions")->name("permissions");
    });
});
