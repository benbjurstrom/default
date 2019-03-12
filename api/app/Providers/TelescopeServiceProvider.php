<?php

namespace App\Providers;

use Laravel\Horizon\Horizon;
use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\TelescopeServiceProvider as Provider;
use Illuminate\Support\Facades\Route;

class TelescopeServiceProvider extends Provider
{
    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        if(app()->environment() === 'admin'){
            Route::group($this->routeConfiguration(), function () {
                $this->loadRoutesFrom(__DIR__.'/../../vendor/laravel/telescope/src/Http/routes.php');
            });
        }
    }

    /**
     * Get the Telescope route group configuration array.
     *
     * @return array
     */
    protected function routeConfiguration()
    {
        return [
            'domain' => config('telescope.domain', null),
            'namespace' => 'Laravel\Telescope\Http\Controllers',
            'prefix' => config('telescope.path'),
            'middleware' => 'telescope',
        ];
    }
}
