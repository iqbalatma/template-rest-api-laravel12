<?php

use App\Http\Controllers\Auth\AuthenticateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix("auth")->name("auth.")->controller(AuthenticateController::class)->group(function () {
    Route::post("authenticate", "authenticate");
});
