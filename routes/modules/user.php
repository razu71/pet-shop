<?php

use App\Http\Controllers\AuthController;

Route::prefix('user/')->group(function () {
    Route::post('login', [AuthController::class, 'userLogin']);

    //protected routes
    Route::middleware(['jwt.auth','user'])->group(function () {

        Route::get('logout', [AuthController::class, 'userLogout']);
    });
});
