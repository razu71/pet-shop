<?php

use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\Guest\BrandController;
use App\Http\Controllers\Guest\CategoryController;
use App\Http\Controllers\Guest\ProductController;

Route::get('categories', CategoryController::class);
Route::get('brands', BrandController::class);
//get file
Route::get('file/{uuid}', [FileUploadController::class, 'getFile']);

//product
Route::get('product/{uuid}', [ProductController::class, 'getSingleProduct']);
Route::get('products', [ProductController::class, 'getProducts']);
