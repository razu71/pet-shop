<?php

use App\Http\Controllers\API\AuthController;

Route::prefix('user/')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    //protected routes
    Route::middleware(['jwt.auth','user'])->group(function () {

    });
});
