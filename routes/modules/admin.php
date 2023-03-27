<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProductController;
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
    Route::prefix('product')->group(function (){
        Route::post('create', [ProductController::class, 'createNewProduct']);
        Route::put('{uuid}', [ProductController::class, 'updateProduct']);
        Route::delete('{uuid}', [ProductController::class, 'deleteProduct']);
    });

    //file upload
    Route::post('file/upload',[FileUploadController::class, 'uploadFile']);
});
