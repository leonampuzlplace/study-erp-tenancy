<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        $this->mapWebRoutes();
        $this->mapApiRoutes();
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            $user = currentUser() ?? $request->user();
            return Limit::perMinute(60)->by(
                ($user['id'] ?? null) ?: $request->ip()
            );
        });
    }

    protected function mapWebRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::middleware('web')
            ->domain($domain)
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        }
    }

    protected function mapApiRoutes()
    {
        // Realiza a leitura dos arquivos de rota dentro do diretório routes/api/central
        $basePath = 'routes/api/central/';
        $files = File::allFiles(base_path($basePath));

        // Mapeia cada arquivo registrando no RouteServiceProvider
        foreach ($files as $file) {
            if ($fileName = explode($basePath, $file->getPathName())[1] ?? null) {
                foreach ($this->centralDomains() as $domain) {
                    Route::prefix('api')
                        ->domain($domain)
                        ->middleware('api')
                        ->namespace($this->namespace)
                        ->group(base_path($basePath.$fileName));
                }                
            }
        }
    }

    protected function centralDomains(): array
    {
        return config('tenancy.central_domains');
    }    
}
