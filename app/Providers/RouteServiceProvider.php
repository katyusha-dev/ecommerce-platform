<?php

namespace App\Providers;

use function base_path;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {
    public const HOME = '/';

    public function boot(): void {
//        $this->configureRateLimiting();
        $this->routes(function (): void {
            Route::prefix('cdn')->group(base_path('routes/cdn.php'));
            Route::middleware('api')->prefix('api')->group(base_path('routes/api.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void {
        RateLimiter::for('api', fn (Request $request) => Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip()));
    }
}
