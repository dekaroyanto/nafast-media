<?php

namespace App\Providers;

use Illuminate\Routing\Router;

use App\Http\Middleware\CheckRole;
use App\Http\Middleware\CheckCompanyIP;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Router $router)
    {
        // Daftarkan middleware di sini
        $router->aliasMiddleware('role', CheckRole::class);
        $router->aliasMiddleware('check.ip', CheckCompanyIP::class);
    }
}
