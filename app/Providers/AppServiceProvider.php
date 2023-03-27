<?php

namespace App\Providers;

use App\Services\Admin\File\FileInterface;
use App\Services\Admin\File\FileService;
use App\Services\Admin\Product\ProductInterface;
use App\Services\Admin\Product\ProductService;
use App\Services\Admin\User\AdminUserInterface;
use App\Services\Admin\User\AdminUserService;
use App\Services\Auth\AuthInterface;
use App\Services\Auth\AuthService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthInterface::class, AuthService::class);
        $this->app->bind(AdminUserInterface::class, AdminUserService::class);
        $this->app->bind(FileInterface::class, FileService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
