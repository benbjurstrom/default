<?php

namespace App\Providers;

use Laravel\Horizon\Horizon;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\HorizonServiceProvider as Provider;

class HorizonServiceProvider extends Provider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerEvents();

        if(app()->environment() === 'admin'){
            $this->registerRoutes();
        }

        $this->registerResources();
        $this->defineAssetPublishing();
    }

}
