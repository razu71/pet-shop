<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\ProfileController;

Route::prefix('user/')->group(function () {
    Route::post('login', [AuthController::class, 'userLogin']);

    //protected routes
    Route::middleware(['jwt.auth','user'])->group(function () {
        Route::get('/', [ProfileController::class, 'getUser']);
        Route::put('edit', [ProfileController::class, 'updateUserProfile']);
        Route::get('logout', [AuthController::class, 'userLogout']);
    });
});
