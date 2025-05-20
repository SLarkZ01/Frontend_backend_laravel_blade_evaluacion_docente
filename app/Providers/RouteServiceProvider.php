<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     * En nuestro caso, la redirección se maneja en el controlador según el rol del usuario.
     *
     * @var string
     */
    public const HOME = '/dashboard';
    
    /**
     * Obtiene la ruta de inicio según el rol del usuario.
     *
     * @param int $role_id
     * @return string
     */
    public static function getHomeByRole(int $role_id): string
    {
        switch ($role_id) {
            case 1:
                return route('user.index');
            case 2:
                return route('docente.p_docente');
            case 3:
                return route('Admin.Dashboard');
            default:
                return self::HOME;
        }
    }

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

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
