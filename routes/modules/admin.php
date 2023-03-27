<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\FileUploadController;

Route::prefix('admin/')->group(function () {
    Route::post('login', [AuthController::class, 'adminLogin']);

    //protected routes
    Route::middleware(['jwt.auth','admin'])->group(function () {
        Route::post('create', [AdminUserController::class, 'createNewUser']);
        Route::get('user-listing', [AdminUserController::class, 'userListing']);
        Route::put('user-edit/{uuid}', [AdminUserController::class, 'updateUser']);
        Route::delete('user-delete/{uuid}', [AdminUserController::class, 'deleteUser']);

        Route::get('logout', [AuthController::class, 'adminLogout']);
    });
});

Route::middleware(['jwt.auth','admin'])->group(function (){
    //file upload
    Route::post('file/upload',[FileUploadController::class, 'uploadFile']);
});
