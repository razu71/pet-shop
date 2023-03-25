<?php

use Illuminate\Support\Facades\Route;


Route::prefix('v1/')->group(function (){
    /**
     * admin related routes
     */
    require base_path('routes/modules/admin.php');

    /**
     * user related routes
     */
    require base_path('routes/modules/user.php');
});
