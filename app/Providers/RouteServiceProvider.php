<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')->group(function () {
                Route::localizedGroup(function () {
                    Livewire::setUpdateRoute(function ($handle) {
                        return Route::post('/livewire/update', $handle);
                    });

                    Route::group([], function () {
                        include base_path('routes/web.php');
                    });

                    Route::middleware(['auth', 'store.admin'])
                        ->prefix('store/{store}/admin')
                        ->name('store.admin.')
                        ->group(base_path('routes/store.php'));

                    Route::middleware(['auth'])
                        ->prefix('admin')
                        ->name('admin.')
                        ->group(base_path('routes/admin.php'));
                });
            });

            Route::middleware('payment')
            ->prefix('payment')
            ->name('payment.')
            ->group(base_path('routes/payment.php'));


           
        });
    }
}
