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
        Route::post("logout", "logout")->middleware("auth.jwt:".\Iqbalatma\LaravelJwtAuthentication\Enums\JWTTokenType::ACCESS->name);
        Route::post("refresh", "refresh")->middleware("auth.jwt:".\Iqbalatma\LaravelJwtAuthentication\Enums\JWTTokenType::REFRESH->name);
        Route::get("user", "user")->middleware("auth.jwt:".\Iqbalatma\LaravelJwtAuthentication\Enums\JWTTokenType::ACCESS->name);
    });
