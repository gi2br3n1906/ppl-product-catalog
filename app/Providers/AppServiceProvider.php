<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\EnsureUserIsAdmin;

use Illuminate\Support\Facades\Route as RouteFacade; // helpful if needed

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
    public function boot(): void
    {
        // Register admin middleware alias if Router supports it (no Kernel.php present in repo)
        if ($this->app->bound('router')) {
            $router = $this->app->make('router');
            if (method_exists($router, 'aliasMiddleware')) {
                $router->aliasMiddleware('admin', EnsureUserIsAdmin::class);
            }
        }
    }
}
