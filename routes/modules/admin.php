<?php

use App\Http\Controllers\API\AuthController;

Route::prefix('admin/')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    //protected routes
    Route::middleware(['jwt.auth','admin'])->group(function () {

    });
});
